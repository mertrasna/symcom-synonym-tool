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

    // Handle double-click to add a word as a stop word
    $(document).on("dblclick", ".synonym-word", function(event) {
        event.preventDefault(); 
        event.stopPropagation(); 

        let word = $(this).attr("data-word");

        console.log("Double-clicked word to add as stop word:", word);

        $.ajax({
            url: "add_filler_word.php",  // PHP file to add word to stop words
            type: "POST",
            data: { word: word },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.success) {
                    $(this).addClass("stopword").removeClass("synonym-word");
                    console.log("Stop word added successfully!");
                } else {
                    console.log("Error: " + res.message);
                }
            }.bind(this) 
        });
    });

    // Handle double-click to remove a word from stop words
    $(document).on("dblclick", ".stopword", function(event) {
        event.preventDefault(); 
        event.stopPropagation(); 
        let word = $(this).attr("data-word");

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

    // Function to link selected words
    function linkSelectedWords() {
        let selection = window.getSelection();
        if (!selection.rangeCount) return;

        let range = selection.getRangeAt(0);
        let span = document.createElement("span");
        span.classList.add("linked-words");
        span.textContent = selection.toString();

        range.deleteContents();
        range.insertNode(span);

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
