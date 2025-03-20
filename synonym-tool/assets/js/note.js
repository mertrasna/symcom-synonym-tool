// Note functionality for synonym tool
$(document).ready(function () {
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
        if (response.success) {
          // Pre-fill the note field with existing note
          $("#noteText").val(response.note);
        } else {
          // Clear the note field for a new note
          $("#noteText").val("");
        }

        // Set the selected word in the modal title
        $("#noteModal h3").text(`Add Note for "${selectedWord}"`);

        // Open the modal
        $("#noteModal").show();
      },
      error: function (xhr, status, error) {
        console.error("Error fetching note:", status, error);
        $("#noteText").val("");
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
        alert("Error saving note. Please try again.");
      },
    });
  });

  // Close modal when clicking outside of it
  $(window).click(function (event) {
    if ($(event.target).is("#noteModal")) {
      $("#noteModal").hide();
    }
  });

  // Add indicator for words that have notes when they're loaded
  function checkForExistingNotes() {
    $(".synonym-word").each(function () {
      let word = $(this).attr("data-word");
      if (!word) return;

      const urlParams = new URLSearchParams(window.location.search);
      const mid = urlParams.get("mid") || 5075;

      $.ajax({
        url: "fetch_note.php",
        type: "POST",
        data: {
          word: word,
          master_id: mid,
        },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            $(`.synonym-word[data-word='${word}']`).addClass("has-note");
          }
        },
      });
    });
  }

  // Run once when page loads
  setTimeout(checkForExistingNotes, 1000);
});
