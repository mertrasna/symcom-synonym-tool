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

$limit = 100; // Step 4 requirement to show 100 symptoms at a time
$offset = 0;

$symptoms = [];
$query = "
    SELECT id, BeschreibungOriginal_en, BeschreibungOriginal_de
    FROM quelle_import_test
    WHERE master_id = '$masterId'
    ORDER BY id ASC
    LIMIT $limit OFFSET $offset
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


function processText($text, $stopwords) {
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
        if (in_array($cleanedWord, $stopwords)) {
            $processedText .= "<span class='stopword'>$word</span> ";
        } else {
            $processedText .= "<span class='synonym-word' data-word='$word'>$word</span> ";
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
            </div>
        </div>
    </section>
</div>

<?php include '../inc/footer.php'; ?>


<style>
    .synonym-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    }

    .synonym-table th, .synonym-table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: center;
    }

    .synonym-table th {
    background-color: #f4f4f4;
    }

    .synonym-table input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin: 5px;
    }

    .synonym-explanation {
    margin-top: 10px;
    font-size: 14px;
    color: #555;
    }

    .stopword {
        color: gray;
        font-style: italic;
    }
    .synonym-word {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }
    .synonym-word.green {
        color: green !important;
    }

    
    .split-container {
        display: flex;
        height: calc(100vh - 100px);
    }

    
    .toggle-btn {
        margin-right: 15px;
        padding: 8px 12px;
        background: #28a745; /* Green */
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .toggle-btn:hover {
        background:  #218838;
    }

    
    .left-pane {
        width: 30%;
        background: #f8f9fa;
        border-right: 2px solid #ddd;
        overflow-y: auto;
        transition: width 0.3s ease;
    }

    
    .right-pane {
        width: 70%;
        padding: 20px;
        transition: width 0.3s ease;
    }
</style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".symptom-item").click(function() {
        $(".symptom-item").removeClass("selected");
        $(this).addClass("selected");
    
        let symptomText = $(this).html();
        $("#symptom-details").html(symptomText);

        let firstBlueWord = $(this).find(".synonym-word").first();
        if (firstBlueWord.length) {
        firstBlueWord.trigger("click");
        }
    });

        $(document).ready(function() {
            $("#toggleView").click(function() {
                if ($(".left-pane").is(":visible")) {
                    $(".left-pane").hide();
                    $(".right-pane").css("width", "100%");
                    $(this).text("⇨");
                } else {
                    $(".left-pane").show();
                    $(".right-pane").css("width", "70%");
                    $(this).text("⇦");
                }
            });
        });

        $(document).on("click", ".synonym-word", function() {
            let word = $(this).attr("data-word");

            console.log("Searching synonyms for:", word); // debugging log to see it's working

            $.ajax({
                url: "search_synonym.php",
                type: "POST",
                data: { word: word },
                success: function(response) {
                    console.log("Server Response:", response); // debug
                    let res = JSON.parse(response);
                     if (res.success) {
                         displaySynonyms(word, res.synonyms);
                    } else {
                          alert("No synonym found.");
                     }
                 }
            });
        });

        // function to display synonyms in the right side (added explanation for S, Q, O, U)
        function displaySynonyms(word, synonyms) {
    let html = `
        <div class="pane-header">
            <button id="toggleView" class="toggle-btn">⇦</button>
            <h3>Worksheet</h3>
        </div>
        <h3>Term: ${word}</h3>
        <table class="synonym-table">
            <thead>
                <tr>
                    <th>S</th>
                    <th>Q</th>
                    <th>O</th>
                    <th>U</th>
                    <th>Synonym</th>
                </tr>
            </thead>
            <tbody>
    `;

    synonyms.forEach(syn => {
        let synonymList = [
            syn.strict_synonym,
            syn.synonym_partial_1,
            syn.synonym_general,
            syn.synonym_minor
        ].filter(s => s !== null && s !== ""); // Remove null values

        synonymList.forEach(synonym => {
            html += `
                <tr>
                    <td><input type="checkbox" class="synonym-checkbox" data-type="S" value="${synonym}"></td>
                    <td><input type="checkbox" class="synonym-checkbox" data-type="Q" value="${synonym}"></td>
                    <td><input type="checkbox" class="synonym-checkbox" data-type="O" value="${synonym}"></td>
                    <td><input type="checkbox" class="synonym-checkbox" data-type="U" value="${synonym}"></td>
                    <td>${synonym}</td>
                </tr>
            `;
        });
    });

    html += `
            </tbody>
        </table>
        <p class="synonym-explanation">
            <strong>S</strong> = Synonym, <strong>Q</strong> = Cross-reference, 
            <strong>O</strong> = Generic-term, <strong>U</strong> = Sub-term
        </p>
        <button id="submitSynonyms">Submit</button>
    `;

    $("#worksheet-container").html(html);
}

    $(document).on("click", "#submitSynonyms", function(event) {
        event.preventDefault(); // this will be changed looks like not working

        let selectedSynonyms = [];

        let word = $("#symptom-details").find(".synonym-word").first().text().trim(); // gets the first blue word

        $(".synonym-checkbox:checked").each(function() {
            let synonym = $(this).val();
            let type = $(this).attr("data-type");

            if (!word || !synonym || !type) {
            console.error("⚠️ Missing Data:", { word, synonym, type });
            return;
            }

            let synonymData = { word: word, synonym: synonym, type: type };
            selectedSynonyms.push(synonymData);
        });

        if (selectedSynonyms.length === 0) {
            alert("⚠️ No synonyms selected.");
            return;
        }

        console.log("Sending to server:", selectedSynonyms); // debug

    $.ajax({
        url: "save_synonym.php",
        type: "POST",
        dataType: "json", // response parsed as json
        data: { synonyms: JSON.stringify(selectedSynonyms) },
        success: function(response) {
            console.log("server Response:", response);
            if (response.success) {
                alert("synonyms saved successfully.");
            } else {
                alert("failed to save synonym: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error, xhr.responseText);
            alert("Error saving synonyms.");
        }
    });
});

    });
</script>