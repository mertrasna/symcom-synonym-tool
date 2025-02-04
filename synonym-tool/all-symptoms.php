<?php
include '../config/route.php';
$pageTitle = "Synonymizing Tool";
include '../inc/header.php';
include '../inc/sidebar.php';
$masterId = isset($_GET['mid']) ? intval($_GET['mid']) : 0;

if ($masterId == 0) {
    $midResult = mysqli_query($db, "SELECT DISTINCT master_id FROM quelle_import_test ORDER BY master_id ASC LIMIT 1");
    $row = mysqli_fetch_assoc($midResult);

    if ($row) {
        $firstValidMid = $row['master_id'];
        header("Location: " . $_SERVER['PHP_SELF'] . "?mid=" . $firstValidMid);
        exit;
    } else {
        die("<p style='color:red;'>Error: No valid master ID (mid) found in database.</p>");
    }
}

if (!$db) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

// fetching words from database 
$stopwords = [];
$stopwordsResult = mysqli_query($db, "SELECT name FROM stop_words WHERE active = 1");
while ($row = mysqli_fetch_assoc($stopwordsResult)) {
    $stopwords[] = strtolower($row['name']); // Store stop words in lowercase for easy comparison
}

// fetching the original symptoms from quelle_import_test table 
$symptoms = [];
$query = "
    SELECT 
        id, BeschreibungOriginal_en, BeschreibungOriginal_de
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

// step 1 Exclude all filler words
function processText($text, $stopwords, $synonyms = [])
{
    if (empty($text)) {
        return "<span style='color: red;'>[No symptom text found]</span>";
    }

    $text = preg_replace('/<[^>]+>/', '', $text);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text));

    $words = explode(" ", $text);
    $processedText = "";

    foreach ($words as $word) {
        $cleanedWord = strtolower(trim($word, ".,()")); 
        $wordClass = "synonym-word";

        if (in_array($cleanedWord, $stopwords)) {
            // Graying out stop words
            $processedText .= "<span class='stopword'>$word</span> ";
        } else {
            // Check if the word exists in the synonyms array
            if (in_array($cleanedWord, $synonyms)) {
                $wordClass = "synonym-word green"; // Add the green class
            }

            // Highlighting the non-stop words clickable for synonym classification
             $processedText .= "<span class='$wordClass' data-word='$cleanedWord'>$word</span> ";
        }
    }

    return trim($processedText);
}
?>


<div class="content-wrapper">
    <section class="content-header">
        <h1>Original Symptoms</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?mid=<?php echo $masterId; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Original Symptoms</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Original Symptoms</h3>
                <button id="reloadSymptoms" class="btn btn-primary" style="float:right;">Reload Symptoms</button>
            </div>
            <div class="box-body">
                <div id="symptom-container">
                    <?php if (empty($symptoms)) : ?>
                        <p style="color: red;">No original symptoms found for master ID: <?php echo $masterId; ?></p>
                    <?php else : ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Symptom ID</th>
                                    <th>Original Symptom</th>
                                    <th>Processed Symptom (Stop Words Grayed Out)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($symptoms as $entry) : ?>
                                    <tr class="symptom-item"
                                        data-symptom-id="<?php echo $entry['id']; ?>"
                                        data-original-symptom="<?php echo htmlspecialchars(strip_tags($entry['original_symptom'])); ?>">
                                        <td><?php echo $entry['id']; ?></td>
                                        <td><?php echo htmlspecialchars(strip_tags($entry['original_symptom'])); ?></td> <!-- Removes unwanted tags -->
                                        <td><?php echo processText($entry['original_symptom'], $stopwords); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php

include '../inc/footer.php';
?>


<style>
    .stopword {
        color: gray;
        font-style: italic;
    }
    .synonym-word {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }
</style>

<script src="assets/js/common.js"></script>
<script type="text/javascript">
    $(document).on("click", ".symptom-item", function() {
        var symptomId = $(this).attr("data-symptom-id");
        var originalSymptom = $(this).attr("data-original-symptom");

        console.log("Symptom ID:", symptomId);
        console.log("Original Symptom:", originalSymptom);
    });

    $(window).on("load", function() {
        console.log('Original Symptoms displayed successfully.');
    });

   // Track words that have been marked as synonyms (green)
let greenWords = [];

$(document).on("click", ".synonym-word", function() {
    let word = $(this).attr("data-word");

    console.log("Searching for word:", word); // Check if the word is correctly captured

    // AJAX request to search for the word in the synonym_en table
    $.ajax({
        url: "search_synonym.php",  // The PHP script that will handle the search
        type: "POST",
        data: { word: word },
        success: function(response) {
            console.log("Response from server:", response); // Log the response

            var res = JSON.parse(response);
            if (res.success) {
                // Extract synonyms from the response
                let synonyms = res.synonyms.map(function(synonym) {
                    return synonym.word.toLowerCase();
                });

                // Store the synonyms in the greenWords list (persistent across searches)
                greenWords = [...new Set(greenWords.concat(synonyms))];

                // After the search, loop through each word and check if it is a synonym
                $(".synonym-word").each(function() {
                    let wordText = $(this).attr("data-word").toLowerCase();
                    if (greenWords.includes(wordText)) {
                        $(this).css("color", "green");  
                    } else {
                        $(this).css("color", "blue");  
                    }
                });

                
                let synonymList = "<ul>";
                res.synonyms.forEach(function(synonym) {
                    synonymList += "<li>Synonym ID: " + synonym.synonym_id + "<br>Word: " + synonym.word + "</li>";
                });
                synonymList += "</ul>";
                $("#synonym-search-results").html(synonymList); // Make sure the element exists
            } else {
                alert("No synonym found: " + res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("An error occurred while searching for the synonym.");
        }
    });
});

</script>



