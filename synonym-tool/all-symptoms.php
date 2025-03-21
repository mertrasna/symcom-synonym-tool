<?php
include '../config/route.php';
include '../lang/GermanWords.php';
include '../lang/EnglishWords.php';
$pageTitle = "Synonymizing Tool";
include '../inc/header.php';
include '../inc/sidebar.php';

?>


<link rel="stylesheet" href="assets/css/styles.css">

<?php
$masterId = isset($_GET['mid']) ? intval($_GET['mid']) : 0;

if ($masterId == 0) {
    $midResult = mysqli_query($db, "SELECT DISTINCT master_id FROM quelle_import_test ORDER BY master_id ASC LIMIT 1");
    $row = mysqli_fetch_assoc($midResult);
    if ($row) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?mid=" . $row['master_id']);
        exit;
    } else {
        die("<p style='color:red;'>Error: No valid master ID found in database.</p>");
    }
}

// Determine language based on master ID
if ($masterId == 5072) {
    $synonymTable = "synonym_de";
    $descriptionColumn = "BeschreibungOriginal_de";
} elseif ($masterId == 5075) {
    $synonymTable = "synonym_en";
    $descriptionColumn = "BeschreibungOriginal_en";
} else {
    $synonymTable = "synonym_en"; // Default to English
    $descriptionColumn = "BeschreibungOriginal_en";
}

if (!$db) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

$stopwords = [];
$stopwordsResult = mysqli_query($db, "SELECT name FROM stop_words WHERE active = 1");
while ($row = mysqli_fetch_assoc($stopwordsResult)) {
    $stopwords[] = strtolower($row['name']); 
}

// Limit symptoms fetched by 200 for performance improvements 
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$symptoms = [];
$query = "
    SELECT id, $descriptionColumn AS original_symptom
    FROM quelle_import_test
    WHERE master_id = '$masterId'
    ORDER BY id ASC
    LIMIT 200 OFFSET $offset
";
$symptomResult = mysqli_query($db, $query);
if (!$symptomResult) {
    die("<p style='color:red;'>SQL Error: " . mysqli_error($db) . "</p>");
}

while ($row = mysqli_fetch_assoc($symptomResult)) {
    $symptoms[] = [
        "id" => $row['id'],
        "original_symptom" => $row['original_symptom']
    ];
}

function processText($text, $stopwords, $db, $synonymTable) {
    if (empty($text)) {
        return "<span style='color: red;'>[No symptom text found]</span>";
    }

    // Normalize text: Remove HTML tags, decode entities, collapse extra spaces.
    $text = strip_tags($text);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text));

    // 1. Retrieve all phrases (multi-word entries) marked as yellow.
    $query = "SELECT word FROM $synonymTable WHERE isyellow = 1";
    $result = mysqli_query($db, $query);
    $phrases = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (str_word_count($row['word']) > 1) { // Keep only actual phrases
                $phrases[] = $row['word'];
            }
        }
    }

    // 2. Sort phrases by length (longest first) to ensure we highlight the largest phrase.
    usort($phrases, function ($a, $b) {
        return strlen($b) - strlen($a);
    });

    // 3. Replace each full phrase in the text with a placeholder.
    $placeholderMapping = [];
    foreach ($phrases as $index => $phrase) {
        $placeholder = "[[[PHRASE_$index]]]";
        $placeholderMapping[$placeholder] = $phrase;

        // Use strict matching to ensure exact phrase replacement
        $pattern = '/\b' . preg_quote($phrase, '/') . '\b/i';
        $text = preg_replace($pattern, $placeholder, $text);
    }

    // 4. Process the remaining text word by word.
    $words = explode(" ", $text);
    $processedWords = [];
    foreach ($words as $word) {
        if (strpos($word, '[[[PHRASE_') !== false) {
            $processedWords[] = $word; // Leave placeholders untouched
            continue;
        }

        $cleaned = strtolower(trim($word, ".,()"));

        if (in_array($cleaned, $stopwords)) {
            $processedWords[] = "<span class='stopword' data-word='" . htmlspecialchars($word) . "'>" . htmlspecialchars($word) . "</span>";
        } else {
            // Query the database for isyellow and isgreen status.
            $checkQuery = "SELECT isyellow, isgreen FROM $synonymTable 
                           WHERE word = '" . mysqli_real_escape_string($db, $cleaned) . "' 
                           ORDER BY isyellow DESC, isgreen DESC 
                           LIMIT 1";
            $checkResult = mysqli_query($db, $checkQuery);
            $isGreen = false;
            $isYellow = false;

            if ($checkResult) {
                $checkRow = mysqli_fetch_assoc($checkResult);
                if ($checkRow) {
                    if (!empty($checkRow['isyellow']) && $checkRow['isyellow'] == 1) {
                        $isYellow = true;
                    }
                    if (!empty($checkRow['isgreen']) && $checkRow['isgreen'] == 1) {
                        $isGreen = true;
                    }
                }
            }

            // Assign class based on priority: Yellow (phrase) > Green (single word)
            if ($isYellow) {
                $class = 'synonym-word yellow-word';
            } elseif ($isGreen) {
                $class = 'synonym-word green';
            } else {
                $class = 'synonym-word';
            }

            $processedWords[] = "<span class='$class' data-word='" . htmlspecialchars($word) . "'>" . htmlspecialchars($word) . "</span>";
        }
    }

    // 5. Convert processed words array back to a string
    $processedText = implode(" ", $processedWords);

    // 6. Replace placeholders with their full highlighted versions.
    foreach ($placeholderMapping as $placeholder => $phrase) {
        $replacement = "<span class='synonym-word yellow-word' data-word='" . htmlspecialchars($phrase) . "'>" . htmlspecialchars($phrase) . "</span>";
        $processedText = str_replace($placeholder, $replacement, $processedText);
    }

    return trim($processedText);
}




?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Synonymizing Tool</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?mid=<?php echo $masterId; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Original Symptoms</li>
        </ol>
    </section>

    <section class="content">
        <div class="split-container">
            <div id="symptom-list-container" class="left-pane">
                <div class="pane-header">
                    <h3>Symptoms</h3>
                    <button id="reloadSymptoms" style="margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; border: none; background-color: #007bff; color: white; cursor: pointer;">
                    🔄 Reload New Symptoms
                </button>
                <button id="resetToStart" style="margin-bottom: 10px; padding: 5px 10px; border-radius: 5px; border: none; background-color: #28a745; color: white; cursor: pointer;">
                    ⬅️ Back to Start
                </button>
                </div>
                <div class="symptom-list">
                    <?php if (empty($symptoms)) : ?>
                        <p style="color: red;">No symptoms found for master ID: <?php echo $masterId; ?></p>
                    <?php else : ?>
                        <ul>
                    <?php foreach ($symptoms as $entry) : ?>
                        <li class="symptom-item" data-symptom-id="<?php echo $entry['id']; ?>">
                            <span><?php echo processText($entry['original_symptom'], $stopwords ,$db, $synonymTable); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div id="worksheet-container" class="right-pane">
                <div class="pane-header">
                    <button id="toggleView" class="toggle-btn">⇦</button>
                    <h3>Worksheet</h3>
                </div>
                
                <div id="symptom-details">
                    <p>Select a word to see its synonym.</p>
                </div>

                <?php if ($masterId == 5072) : ?>
    <!-- Korrekturen Button for German Synonyms -->
    <div id="korrekturen-container">
        <a id="korrekturen-btn" href="#" target="_blank" class="korrekturen-button">🔎 Check Korrekturen</a>
    </div>

    <!-- Wörterbuchnetz Button for German Synonyms -->
    <div id="woerterbuchnetz-container">
        <a id="woerterbuchnetz-btn" href="#" target="_blank" class="dictionary-button">📖 Search in Wörterbuchnetz</a>
    </div>

<?php elseif ($masterId == 5075) : ?>
    <!-- Dictionary.com Button for English Synonyms -->
    <div id="dictionary-container">
        <a id="dictionary-btn" href="#" target="_blank" class="dictionary-button">🔎 Search on Dictionary.com</a>
    </div>
<?php endif; ?>



<div id="symptom-details2">
    <form id="synonymForm">
        <table id="synonymTable" class="styled-table">
            <thead>
                <tr>
                    <th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th>
                </tr>
            </thead>
            <tbody>
                <!-- Synonyms will be dynamically inserted here -->
            </tbody>
        </table>
        <div style="display: flex; align-items: center; margin-top: 10px;">
            <div style="margin-right: 20px;">
                <input type="checkbox" id="notSureCheckbox" name="notSure" value="1"> Not Sure
            </div>
            <button type="button" id="newAssignmentBtn" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">New Assignment</button>
            <button type="button" id="addNoteBtn" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 5px 10px; margin-left: 10px; cursor: pointer;">Add Note</button>
        </div>

        <button type="submit" id="submitSynonyms">Submit</button>
    </form>
</div>
            </div>
        </div>
    </section>
</div>

<!-- Comment Box Modal -->
<div id="commentModal" class="modal" style="display:none;">
    <div class="modal-content" style="position: relative; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 300px; background: #fff;">
        <span class="close-modal" style="position: absolute; right: 10px; top: 5px; cursor: pointer; font-size: 20px;">&times;</span>
        <h3>Enter your comment</h3>
        <textarea id="commentText" placeholder="Enter reason for uncertainty..." rows="3" cols="30"></textarea>
        <br>
        <button id="saveComment">Save</button>
        <button id="closeComment">Close</button>
    </div>
    <input type="hidden" id="masterId" value="<?php echo $masterId; ?>">

</div>

<!-- Note Modal -->
<div id="noteModal" class="modal" style="display:none;">
  <div class="modal-content">
    <!-- Close button -->
    <span class="close-note-modal" style="cursor:pointer; font-size: 20px;">&times;</span>

    <!-- Title: Updates dynamically based on whether it's adding or viewing a note -->
    <h3>Note</h3>

    <!-- Note Text Area (Disabled for Viewing) -->
    <textarea id="noteText" rows="4" cols="50" readonly></textarea>
    
    <br>

    <!-- Save Note Button (Hidden when viewing a note) -->
    <button id="saveNote">Save</button>
    
    <!-- Close Modal Button -->
    <button id="closeNote">Close</button>
  </div>
</div>


<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    const masterId = <?= json_encode($masterId); ?>;
</script>
<script>
  var nonSecureFlag = <?php echo json_encode(isset($non_secure_flag) ? $non_secure_flag : 0); ?>;
</script>








<!-- Load external JavaScript files -->
<script src="assets/js/ui.js"></script>
<script src="assets/js/ajaxHandlers.js"></script>
<script src="assets/js/eventListeners.js"></script>
<script src="assets/js/note.js"></script>
<script src="assets/js/helpers.js"></script>
<script src="assets/js/modal.js"></script>
<script src="assets/js/hover.js"></script>


<?php include '../inc/footer.php';?>