<?php
include_once __DIR__ . '/../../config/route.php'; 
include_once __DIR__ . '/../../inc/header.php';  
include_once __DIR__ . '/../../inc/sidebar.php'; 

$pageTitle = "Synonymizing Tool";

// gets the master ID from the URL, its 5072
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

// checking database connection
if (!$db) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

// Load stop words from "stop words" table 
$stopwords = [];
$stopwordsResult = mysqli_query($db, "SELECT name FROM stop_words WHERE active = 1");
while ($row = mysqli_fetch_assoc($stopwordsResult)) {
    $stopwords[] = strtolower($row['name']); 
}

// fetching german symptoms from the database
$symptoms = [];
$query = "
    SELECT id, BeschreibungOriginal_de
    FROM quelle_import_test
    WHERE master_id = '$masterId'
    ORDER BY id ASC
";
$symptomResult = mysqli_query($db, $query);
if (!$symptomResult) {
    die("<p style='color:red;'>SQL Error: " . mysqli_error($db) . "</p>");
}

while ($row = mysqli_fetch_assoc($symptomResult)) {
    if (!empty($row['BeschreibungOriginal_de'])) {
        $symptoms[] = [
            "id" => $row['id'],
            "original_symptom" => $row['BeschreibungOriginal_de']
        ];
    }
}

// Function to process symptoms: highlight stop words & synonyms
// this will be moved to backend in the future
function processText($text, $stopwords) {
    if (empty($text)) {
        return "<span style='color: red;'>[No symptom text found]</span>";
    }

    // remove html tags, decode html entities, and trim whitespace
    $text = preg_replace('/<[^>]+>/', '', $text);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text));

    $words = explode(" ", $text);
    $processedText = "";

    foreach ($words as $word) {
        $cleanedWord = strtolower(trim($word, ".,()"));
        if (in_array($cleanedWord, $stopwords)) {
            $processedText .= "<span class='stopword gray'>$word</span> ";
        } else {
            $processedText .= "<span class='synonym-word blue' data-word='$word'>$word</span> ";
        }
    }

    return trim($processedText);
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Synonymization Tool</h1>
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
                                    <span><?php echo processText($entry['original_symptom'], $stopwords); ?></span>
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
                    <p>Select a symptom from the left list to start working on it.</p>
                </div>
                <div>
                    <h3>Selected Word: <span id="selected-word"></span></h3>
                    <ul id="synonym-list"></ul>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>

<!-- Link JavaScript & CSS -->
<link rel="stylesheet" href="../../assets/css/worksheet.css">
<script src="../../assets/js/worksheet.js"></script>
