$(document).ready(function () {
  let greenWords = new Set();

  // Toggle left-right pane view
  $("#toggleView").click(function () {
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
  $(".symptom-item").click(function () {
    let symptomText = $(this).html();
    $("#symptom-details").html(symptomText);
  });

  // Handle clicking on synonym words
  // Handle clicking on synonym words
  $(document).on("click", ".synonym-word", function () {
    let word = $(this).attr("data-word");
    selectedWord = word; // Store globally
    console.log("Searching for word:", word);

    $.ajax({
      url: "search_synonym.php",
      type: "POST",
      data: { word: word },
      success: function (response) {
        console.log("Response from server:", response);
        let res = JSON.parse(response);

        if (res.success) {
          let synonymsList = [];

          // Extract and categorize synonyms
          res.synonyms.forEach((syn) => {
            if (syn.strict_synonym)
              synonymsList.push({ type: "S", word: syn.strict_synonym });
            if (syn.synonym_partial_1)
              synonymsList.push({ type: "Q", word: syn.synonym_partial_1 });
            if (syn.synonym_general)
              synonymsList.push({ type: "O", word: syn.synonym_general });
            if (syn.synonym_minor)
              synonymsList.push({ type: "U", word: syn.synonym_minor });
          });

          // Flatten comma-separated values
          let finalSynonyms = [];
          synonymsList.forEach((item) => {
            item.word.split(",").forEach((syn) => {
              finalSynonyms.push({ type: item.type, word: syn.trim() });
            });
          });

          // Store words that should be green
          greenWords = new Set([
            ...greenWords,
            ...finalSynonyms.map((syn) => syn.word.toLowerCase()),
          ]);

          // Generate the table
          let tableHTML = `
                    <p><b>Selected Word:</b> <span id="selected-word">${word}</span></p>
                    <form id="synonymForm">
                        <table id="synonymTable" class="styled-table">
                            <thead>
                                <tr>
                                    <th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th>
                                </tr>
                            </thead>
                            <tbody>`;

          finalSynonyms.forEach((syn) => {
            let highlightClass = greenWords.has(syn.word.toLowerCase())
              ? "green-text"
              : "blue-text";

            tableHTML += `
                        <tr>
                            <td><input type="checkbox" name="S" value="${
                              syn.word
                            }" ${syn.type === "S" ? "checked" : ""}></td>
                            <td><input type="checkbox" name="Q" value="${
                              syn.word
                            }" ${syn.type === "Q" ? "checked" : ""}></td>
                            <td><input type="checkbox" name="O" value="${
                              syn.word
                            }" ${syn.type === "O" ? "checked" : ""}></td>
                            <td><input type="checkbox" name="U" value="${
                              syn.word
                            }" ${syn.type === "U" ? "checked" : ""}></td>
                            <td class="${highlightClass}">${syn.word}</td>
                        </tr>`;
          });

          tableHTML += `
                            </tbody>
                        </table>
                        <button type="submit" id="submitSynonyms">Submit</button>
                    </form>`;

          // Replace the contents of #symptom-details to ensure visibility
          $("#symptom-details").html(tableHTML);

          // Apply green highlight to already stored synonyms in the main text as well
          $(".synonym-word").each(function () {
            let wordText = $(this).attr("data-word").toLowerCase();
            if (greenWords.has(wordText)) {
              $(this).addClass("green-text").removeClass("blue-text");
            }
          });
        } else {
          $("#symptom-details").html(
            `<p style='color:red;'>No synonyms found for ${word}.</p>`
          );
        }
      },
    });
  });

  $(document).on("click", ".synonym-word", function () {
    let word = $(this).attr("data-word");

    console.log("Searching for word:", word);

    $.ajax({
      url: "search_synonym.php",
      type: "POST",
      data: { word: word },
      success: function (response) {
        console.log("Response from server:", response);

        var res = JSON.parse(response);
        if (res.success) {
          let synonyms = res.synonyms.map((synonym) =>
            synonym.word.toLowerCase()
          );
          greenWords = new Set([...greenWords, ...synonyms]);

          $(".synonym-word").each(function () {
            let wordText = $(this).attr("data-word").toLowerCase();
            if (greenWords.has(wordText)) {
              $(this).addClass("green");
            }
          });
        } else {
          console.log("No synonym found: " + res.message);
        }
      },
    });
  });

  // **Function to re-fetch synonyms after update**
  function fetchSynonyms(word) {
    $.ajax({
      url: "search_synonym.php",
      type: "POST",
      data: { word: word },
      success: function (response) {
        try {
          let res = JSON.parse(response);
          if (res.success) {
            selectedWord = res.synonyms[0].word; // ✅ Directly store the word from DB response
            console.log("✅ Selected Word:", selectedWord);
            updateWorksheet(selectedWord, res.synonyms);
          } else {
            alert("No synonym found");
          }
        } catch (e) {
          console.error("❌ Error parsing JSON:", response);
        }
      },
      error: function (xhr, status, error) {
        console.error("❌ AJAX Error:", status, error);
      },
    });
  }

  // Handle form submission
  $(document).on("submit", "#synonymForm", function (event) {
    event.preventDefault();

    if (!selectedWord || selectedWord.trim() === "") {
      alert("Error: Selected word is empty.");
      return;
    }

    let synonyms = { S: [], Q: [], O: [], U: [] };

    $("#synonymTable tbody tr").each(function () {
      let synonymText = $(this).find("td:last").text().trim();
      let entry = { word: synonymText };

      if ($(this).find("td:eq(0) input").is(":checked")) synonyms.S.push(entry);
      if ($(this).find("td:eq(1) input").is(":checked")) synonyms.Q.push(entry);
      if ($(this).find("td:eq(2) input").is(":checked")) synonyms.O.push(entry);
      if ($(this).find("td:eq(3) input").is(":checked")) synonyms.U.push(entry);
    });

    console.log("🛠️ Sending update:", {
      word: selectedWord,
      synonyms: synonyms,
    });

    $.ajax({
      url: "update_synonym.php",
      type: "POST",
      data: { word: selectedWord, synonyms: JSON.stringify(synonyms) },
      success: function (response) {
        try {
          let res = JSON.parse(response);
          console.log("✅ Update Response:", res);
          alert(res.message);
        } catch (e) {
          console.error("❌ Invalid JSON Response:", response);
        }
      },
      error: function (xhr, status, error) {
        console.error("❌ AJAX Error:", status, error);
      },
    });
  });

  // Handle double-click to add a word as a stop word
  $(document).on("dblclick", ".synonym-word", function (event) {
    event.preventDefault();
    event.stopPropagation();

    let word = $(this).attr("data-word");

    console.log("Double-clicked word to add as stop word:", word);

    $.ajax({
      url: "add_filler_word.php", // PHP file to add word to stop words
      type: "POST",
      data: { word: word },
      success: function (response) {
        let res = JSON.parse(response);
        if (res.success) {
          $(this).addClass("stopword").removeClass("synonym-word");
          console.log("Stop word added successfully!");
        } else {
          console.log("Error: " + res.message);
        }
      }.bind(this),
    });
  });

  // Handle double-click to remove a word from stop words
  $(document).on("dblclick", ".stopword", function (event) {
    event.preventDefault();
    event.stopPropagation();
    let word = $(this).attr("data-word");

    console.log("Double-clicked word to remove as stop word:", word);

    $.ajax({
      url: "remove_filler_word.php", // PHP file to remove word from stop words
      type: "POST",
      data: { word: word },
      success: function (response) {
        let res = JSON.parse(response);
        if (res.success) {
          $(this).removeClass("stopword").addClass("synonym-word");
          console.log("Stop word removed successfully!");
        } else {
          console.log("Error: " + res.message);
        }
      }.bind(this),
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
  $(document).keydown(function (event) {
    if (event.ctrlKey && event.key === "k") {
      event.preventDefault();
      linkSelectedWords();
    }
  });

  // Right-click option to link words
  $(document).on("contextmenu", function (event) {
    event.preventDefault();
    linkSelectedWords();
  });
});
