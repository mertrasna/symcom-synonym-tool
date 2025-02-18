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

$symptoms = [];
$query = "
    SELECT id, BeschreibungOriginal_en, BeschreibungOriginal_de
    FROM quelle_import_test
    WHERE master_id = '$masterId'
    ORDER BY id ASC
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

                <!-- 🔥 Dynamic Check Korrekturen Button -->
                <div id="korrekturen-container">
                    <a id="korrekturen-btn" href="#" target="_blank" class="korrekturen-button">🔎 Check korrekturen for ""</a>
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
        <div id="commentSection" style="display: none;">
            <textarea id="commentText" placeholder="Enter reason for uncertainty..." rows="3" cols="30"></textarea>
        </div>
    </div>
                        <button type="submit" id="submitSynonyms">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load external JavaScript file -->
<script src="assets/js/scripts.js"></script>

<?php include '../inc/footer.php'; ?>
