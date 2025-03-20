// Note functionality for synonym tool
$(document).ready(function () {
  // Track processed words to prevent duplicate fetches
  let processedWords = new Set();
  // Debounce timer for fetching notes
  let notesFetchTimer = null;

  // Function to fetch notes with debounce
  function debouncedFetchNote(word) {
    // Clear any existing timer
    if (notesFetchTimer) {
      clearTimeout(notesFetchTimer);
    }

    // If we've already processed this word, don't fetch again
    if (processedWords.has(word)) {
      console.log(`✅ Note for '${word}' already fetched. Skipping request.`);
      return;
    }

    // Set a timer to fetch the note after a delay
    notesFetchTimer = setTimeout(function () {
      // Get masterId from URL or use default (5075 for English)
      const urlParams = new URLSearchParams(window.location.search);
      const mid = urlParams.get("mid") || 5075;

      console.log(`🔍 Fetching note for word: ${word}, master_id: ${mid}`);

      $.ajax({
        url: "fetch_note.php",
        type: "POST",
        data: {
          word: word,
          master_id: mid,
        },
        dataType: "json",
        success: function (response) {
          console.log("📝 Note fetch response:", response);
          // Mark this word as processed
          processedWords.add(word);

          // If there's a successful note, add the indicator class
          if (
            response.success &&
            response.note &&
            response.note.trim() !== ""
          ) {
            $(`.synonym-word[data-word='${word}']`).addClass("has-note");
          }
        },
        error: function (xhr, status, error) {
          console.error("❌ Error fetching note:", status, error);
          // Still mark as processed to prevent repeated attempts
          processedWords.add(word);
        },
      });
    }, 2000); // 2-second delay
  }

  // Open the note modal when Add Note button is clicked
  $(document).on("click", "#addNoteBtn", function () {
    let selectedWord = $("#selected-word").text().trim();
    if (!selectedWord) {
      alert("Please select a synonym word first.");
      return;
    }

    // Get masterId from URL or use default (5075 for English)
    const urlParams = new URLSearchParams(window.location.search);
    const mid = urlParams.get("mid") || 5075;

    // Check if there's an existing note
    $.ajax({
      url: "fetch_note.php",
      type: "POST",
      data: {
        word: selectedWord,
        master_id: mid,
      },
      dataType: "json",
      success: function (response) {
        // Log the response for debugging
        console.log("Fetch note response:", response);

        if (response.success) {
          $("#noteText").val(response.note);
        } else {
          $("#noteText").val(""); // Ensure the field is empty for new notes
        }

        // Set modal title
        $("#noteModal h3").text(`Add Note for "${selectedWord}"`);

        // Enable editing when using "Add Note"
        $("#noteText").prop("readonly", false);

        // Show the Save button again
        $("#saveNote").show();

        // Open the modal
        $("#noteModal").show();
      },
      error: function (xhr, status, error) {
        console.error("Error fetching note:", status, error);
        console.error("Response:", xhr.responseText);
        $("#noteText").val(""); // Clear on error
        $("#noteModal").show();
      },
    });
  });

  // Close the note modal
  $(document).on("click", ".close-note-modal, #closeNote", function () {
    $("#noteModal").hide();
  });

  // Save the note
  $(document).on("click", "#saveNote", function () {
    let selectedWord = $("#selected-word").text().trim();
    let noteText = $("#noteText").val();

    // Get masterId from URL or use default
    const urlParams = new URLSearchParams(window.location.search);
    const mid = urlParams.get("mid") || 5075;

    // Save note to database
    $.ajax({
      url: "save_note.php",
      type: "POST",
      data: {
        word: selectedWord,
        note: noteText,
        master_id: mid,
      },
      dataType: "json",
      success: function (response) {
        console.log("Save note response:", response);

        if (response.success) {
          alert("Note saved successfully!");

          // Mark the synonym as having a note
          if (noteText.trim() !== "") {
            $(`.synonym-word[data-word='${selectedWord}']`).addClass(
              "has-note"
            );
          } else {
            $(`.synonym-word[data-word='${selectedWord}']`).removeClass(
              "has-note"
            );
          }

          // Close the modal
          $("#noteModal").hide();
        } else {
          alert("Error saving note: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.error("Response:", xhr.responseText);
        alert("Error saving note. Check console for details.");
      },
    });
  });

  $(document).on("click", "#viewNoteBtn", function () {
    let selectedWord = $("#selected-word").text().trim();
    if (!selectedWord) {
      alert("Please select a synonym word first.");
      return;
    }

    // Get masterId from URL or use default (5075 for English)
    const urlParams = new URLSearchParams(window.location.search);
    const mid = urlParams.get("mid") || 5075;

    console.log("Viewing note for:", selectedWord, "Master ID:", mid);

    // Fetch the existing note
    $.ajax({
      url: "fetch_note.php",
      type: "POST",
      data: {
        word: selectedWord,
        master_id: mid,
      },
      dataType: "json",
      success: function (response) {
        console.log("View note response:", response);

        // Either use the note from the response or show a default message
        if (response.success && response.note && response.note.trim() !== "") {
          $("#noteText").val(response.note);
        } else {
          // Check for specific error conditions
          if (response.message && response.message.includes("not found")) {
            $("#noteText").val("No note has been saved for this word yet.");
          } else {
            $("#noteText").val("No note available for this synonym.");
          }
        }

        // Set modal title
        $("#noteModal h3").text(`View Note for "${selectedWord}"`);

        // Set textarea to readonly for viewing
        $("#noteText").prop("readonly", true);

        // Hide the Save button in View Mode
        $("#saveNote").hide();

        // Open the modal
        $("#noteModal").show();
      },
      error: function (xhr, status, error) {
        console.error("Error fetching note:", status, error);
        console.error("Response:", xhr.responseText);
        alert("Could not retrieve the note. Please try again later.");
      },
    });
  });

  // Ensure "Save Note" button is shown again when opening the Add Note modal
  $(document).on("click", "#addNoteBtn", function () {
    $("#saveNote").show();
  });

  // Close modal when clicking outside of it
  $(window).click(function (event) {
    if ($(event.target).is("#noteModal")) {
      $("#noteModal").hide();
    }
  });

  // Add indicator for words that have notes when they're loaded
  function initializeNotes() {
    console.log("📝 Initializing notes for visible synonyms...");

    // Only process the first 5 words initially to prevent flooding
    let count = 0;
    const MAX_INITIAL = 5;

    $(".synonym-word.green, .synonym-word.yellow-word").each(function () {
      if (count < MAX_INITIAL) {
        let word = $(this).attr("data-word");
        if (word && !processedWords.has(word)) {
          debouncedFetchNote(word);
          count++;
        }
      }
    });
  }

  // Run initialization after a short delay
  setTimeout(initializeNotes, 1000);

  // Improved click handler for synonym words - connect to existing event handlers
  $(document).on("click", ".synonym-word", function () {
    let selectedWord = $(this).attr("data-word").trim();
    // Fetch note with debounce - add this line to existing handlers
    debouncedFetchNote(selectedWord);
    // Original functionality continues automatically...
  });
});
