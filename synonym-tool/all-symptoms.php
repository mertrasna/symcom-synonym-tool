<?php
include '../config/route.php';
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

if (!$db) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

$stopwords = [];
$stopwordsResult = mysqli_query($db, "SELECT name FROM stop_words WHERE active = 1");
while ($row = mysqli_fetch_assoc($stopwordsResult)) {
    $stopwords[] = strtolower($row['name']); 
}

// limit the symptoms fetched by 200 for performance improvements 
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$symptoms = [];
$query = "
    SELECT id, BeschreibungOriginal_en, BeschreibungOriginal_de
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
    $originalSymptom = !empty($row['BeschreibungOriginal_en']) ? $row['BeschreibungOriginal_en'] : $row['BeschreibungOriginal_de'];
    $symptoms[] = [
        "id" => $row['id'],
        "original_symptom" => $originalSymptom
    ];
}

function processText($text, $stopwords, $db) {
    if (empty($text)) {
        return "<span style='color: red;'>[No symptom text found]</span>";
    }

    // Remove any HTML tags and decode entities
    $text = preg_replace('/<[^>]+>/', '', $text);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text));

    $words = explode(" ", $text);
    $processedText = "";

    foreach ($words as $word) {
        // Clean the word for database lookup
        $cleanedWord = strtolower(trim($word, ".,()"));
        
        // Check if it's a stopword
        if (in_array($cleanedWord, $stopwords)) {
            $processedText .= "<span class='stopword' data-word='$word'>$word</span> ";
        } else {
            // Query to check if the word is marked as green
            $checkQuery = "SELECT isgreen FROM synonym_de WHERE word LIKE '%" . mysqli_real_escape_string($db, $cleanedWord) . "%' LIMIT 1";
            $checkResult = mysqli_query($db, $checkQuery);
            $isGreen = false;
            if ($checkResult) {
                $checkRow = mysqli_fetch_assoc($checkResult);
                if ($checkRow && isset($checkRow['isgreen']) && $checkRow['isgreen'] == 1) {
                    $isGreen = true;
                }
            }
            
            // Add extra class if the word is green
            $class = $isGreen ? 'synonym-word green' : 'synonym-word';
            $processedText .= "<span class='$class' data-word='$word'>$word</span> ";
        }
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
                                <li class="symptom-item"
                                    data-symptom-id="<?php echo $entry['id']; ?>"
                                    data-original-symptom="<?php echo htmlspecialchars(strip_tags($entry['original_symptom'])); ?>">
                                    <span><?php echo processText($entry['original_symptom'], $stopwords ,$db); ?></span>
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

                <!-- Dynamic Check Korrekturen Button -->
                <div id="korrekturen-container">
                    <a id="korrekturen-btn" href="#" target="_blank" class="korrekturen-button">🔎 Check korrekturen for ""</a>
                </div>
                <!-- Dynamic Dictionary Network Button (Hidden Initially) -->
<div id="woerterbuchnetz-container" style="display: none;">
    <a id="woerterbuchnetz-btn" href="#" target="_blank" class="dictionary-button">🔎 Search in Wörterbuchnetz for ""</a>
</div>



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
                        <div>
                            <input type="checkbox" id="notSureCheckbox"> Not Sure
                            <!-- The comment section is now removed from here -->
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
</div>

<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load external JavaScript files -->
<script src="assets/js/ui.js"></script>
<script src="assets/js/ajaxHandlers.js"></script>
<script src="assets/js/eventListeners.js"></script>
<script src="assets/js/helpers.js"></script>
<script src="assets/js/modal.js"></script>
<script src="assets/js/woerter.js"></script>

