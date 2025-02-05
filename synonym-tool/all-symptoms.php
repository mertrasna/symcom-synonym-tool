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
            $processedText .= "<span class='stopword' data-word='$word'>$word</span> ";
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
        background: #007bff;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-btn:hover {
        background: #0056b3;
    }

    
    .left-pane {
        width: 30%;
        background: #f8f9fa;
        border-right: 2px solid #ddd;
        overflow-y: auto;
        transition: width 0.3s ease;
    }

    .stopword {
    color: gray;
    font-style: italic;
}

.linked-words {
    background-color: yellow;  /* Highlights linked words */
    border-radius: 5px;
    padding: 2px 4px;
    display: inline-block;
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
    let greenWords = new Set();

    // Toggle left-right pane view
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

    // Handle clicking on a symptom item
    $(".symptom-item").click(function() {
        let symptomText = $(this).html();
        $("#symptom-details").html(symptomText);
    });

    // Handle clicking on synonym words
    $(document).on("click", ".synonym-word", function() {
        let word = $(this).attr("data-word");

        console.log("Searching for word:", word);

        $.ajax({
            url: "search_synonym.php", 
            type: "POST",
            data: { word: word },
            success: function(response) {
                console.log("Response from server:", response);

                var res = JSON.parse(response);
                if (res.success) {
                    let synonyms = res.synonyms.map(synonym => synonym.word.toLowerCase());
                    greenWords = new Set([...greenWords, ...synonyms]);

                    $(".synonym-word").each(function() {
                        let wordText = $(this).attr("data-word").toLowerCase();
                        if (greenWords.has(wordText)) {
                            $(this).addClass("green");
                        }
                    });
                } else {
                    console.log("No synonym found: " + res.message);
                }
            }
        });
    });

    $(document).on("dblclick", ".synonym-word", function(event) {
    event.preventDefault(); 
    event.stopPropagation(); 

    let word = $(this).attr("data-word");

    // Log to console when a word is double-clicked
    console.log("Double-clicked word to add as stop word:", word);

    $.ajax({
        url: "add_filler_word.php",  // PHP file to add word to stop words
        type: "POST",
        data: { word: word },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.success) {
                // Apply the stopword style immediately without waiting for a reload
                $(this).addClass("stopword").removeClass("synonym-word");
                console.log("Stop word added successfully!");
            } else {
                console.log("Error: " + res.message);
            }
        }.bind(this) 
    });
});



$(document).on("dblclick", ".stopword", function(event) {
    event.preventDefault(); 
    event.stopPropagation(); 
    let word = $(this).attr("data-word");

    // Log to console when a word is double-clicked for removal
    console.log("Double-clicked word to remove as stop word:", word);

    $.ajax({
        url: "remove_filler_word.php",  // PHP file to remove word from stop words
        type: "POST",
        data: { word: word },
        success: function(response) {
            let res = JSON.parse(response);
            if (res.success) {
                
                $(this).removeClass("stopword").addClass("synonym-word");
                console.log("Stop word removed successfully!");
            } else {
                console.log("Error: " + res.message);
            }
        }.bind(this) 
    });
});

function linkSelectedWords() {
    let selection = window.getSelection();
    if (!selection.rangeCount) return;

    let range = selection.getRangeAt(0);
    let span = document.createElement("span");
    span.classList.add("linked-words");
    span.textContent = selection.toString();

    // Replace selection with highlighted span
    range.deleteContents();
    range.insertNode(span);

    // Clear selection
    selection.removeAllRanges();
}

// Detect Ctrl + K to link selected words
$(document).keydown(function(event) {
    if (event.ctrlKey && event.key === 'k') {
        event.preventDefault();
        linkSelectedWords();
    }
});

// Right-click option to link words
$(document).on("contextmenu", function(event) {
    event.preventDefault();
    linkSelectedWords();
});




});


</script>


