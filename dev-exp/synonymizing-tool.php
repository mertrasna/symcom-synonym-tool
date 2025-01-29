<?php
// Include necessary files
include '../config/route.php';
include 'sub-section-config.php';

// Set page title
$pageTitle = "Synonymizing Tool";

// Include header and sidebar
include '../inc/header.php';
include '../inc/sidebar.php';

// Check if "mid" (master ID) is provided in the URL
$masterId = isset($_GET['mid']) ? intval($_GET['mid']) : 0;

// If masterId is missing, try to fetch a valid one
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

// Check database connection
if (!$db) {
    die("<p style='color:red;'>Database connection failed: " . mysqli_connect_error() . "</p>");
}

// Fetch stop words from the database
$stopwords = [];
$stopwordsResult = mysqli_query($db, "SELECT name FROM stop_words WHERE language = 'english' AND active = 1");
while ($row = mysqli_fetch_assoc($stopwordsResult)) {
    $stopwords[] = strtolower($row['name']); // Store stop words in lowercase for easy comparison
}

// Fetch original symptoms from `quelle_import_test`
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

// Function to process text: Gray out stop words, highlight non-stop words
function processText($text, $stopwords)
{
    if (empty($text)) {
        return "<span style='color: red;'>[No symptom text found]</span>";
    }

    $words = explode(" ", $text);
    $processedText = "";

    foreach ($words as $word) {
        $cleanedWord = strtolower(trim($word, ".,()")); // Remove punctuation for matching
        if (in_array($cleanedWord, $stopwords)) {
            // Gray out stop words (non-editable)
            $processedText .= "<span class='stopword'>$word</span> ";
        } else {
            // Highlight and make non-stop words clickable for synonym classification
            $processedText .= "<span class='synonym-word' data-word='$word'>$word</span> ";
        }
    }

    return trim($processedText);
}
?>

<!-- Page content -->
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
                                        data-original-symptom="<?php echo htmlspecialchars($entry['original_symptom']); ?>">
                                        <td><?php echo $entry['id']; ?></td>
                                        <td><?php echo !empty($entry['original_symptom']) ? htmlspecialchars($entry['original_symptom']) : "<span style='color: gray;'>[No original symptom]</span>"; ?></td>
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
// Include footer
include '../inc/footer.php';
?>

<!-- Custom Styles -->
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

        // Debugging Output (Check values in Console)
        console.log("Symptom ID:", symptomId);
        console.log("Original Symptom:", originalSymptom);

        // Example: Use these values in an AJAX request
        $.ajax({
            url: "fetch_symptom_details.php",
            type: "POST",
            data: { symptom_id: symptomId, original_symptom: originalSymptom },
            success: function(response) {
                console.log("Response from Server:", response);
                $("#symptom-details").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    });

    $(window).on("load", function() {
        console.log('Original Symptoms displayed successfully.');
    });

    $(".synonym-word").click(function() {
        let word = $(this).attr("data-word");
        alert("You clicked on: " + word + "\nImplement synonym classification here.");
    });

    // Reload Symptoms with AJAX
    $("#reloadSymptoms").click(function() {
        let masterId = "<?php echo $masterId; ?>";
        $.ajax({
            url: "fetch_symptoms.php",
            type: "GET",
            data: { mid: masterId },
            success: function(response) {
                console.log("Reloaded Symptoms:", response);
                $("#symptom-container").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Reload Error:", error);
            }
        });
    });
</script>
