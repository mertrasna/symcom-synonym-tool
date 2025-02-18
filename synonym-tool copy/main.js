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


    // main.js
$(document).ready(function() {
    const tool = new SynonymTool();  // The Receiver
    const invoker = new CommandInvoker();  // The Invoker

    // Button to trigger synonym search
    $(document).on("click", ".synonym-word", function() {
        let word = $(this).attr("data-word");
        
        console.log("Executing search for synonym for:", word);
        const searchCommand = new SearchSynonymCommand(tool, word);
        invoker.executeCommand(searchCommand);  // Execute the command
    });

    // Double-click to add a filler word
    $(document).on("dblclick", ".synonym-word", function(event) {
        event.preventDefault();
        let word = $(this).attr("data-word");

        console.log("Executing add filler word for:", word);
        const addCommand = new AddFillerWordCommand(tool, word);
        invoker.executeCommand(addCommand);  // Execute the command
    });

    // Double-click to remove a filler word
    $(document).on("dblclick", ".stopword", function(event) {
        event.preventDefault();
        let word = $(this).attr("data-word");

        console.log("Executing remove filler word for:", word);
        const removeCommand = new RemoveFillerWordCommand(tool, word);
        invoker.executeCommand(removeCommand);  // Execute the command
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



