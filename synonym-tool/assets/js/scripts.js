$(document).ready(function () {
  let greenWords = new Set();

  // Toggle left-right pane view
  $("#toggleView").click(function () {
    $(".left-pane").toggle();
    $(".right-pane").css("width", $(".left-pane").is(":visible") ? "70%" : "100%");
    $(this).text($(".left-pane").is(":visible") ? "⇦" : "⇨");
  });

  // Handle clicking on a symptom item
  $(".symptom-item").click(function () {
    $("#symptom-details").html($(this).html());
  });

  let selectedWord = "";

  // Handle clicking on synonym words
  $(document).on("click", ".synonym-word", function () {
    selectedWord = $(this).attr("data-word");

    $.ajax({
      url: "search_synonym.php",
      type: "POST",
      data: { word: selectedWord },
      success: function (response) {
        let res = JSON.parse(response);

        if (res.success) {
          let finalSynonyms = [];
          res.synonyms.forEach((syn) => {
            ["strict_synonym", "synonym_partial_1", "synonym_general", "synonym_minor"].forEach((key, index) => {
              if (syn[key]) {
                syn[key].split(",").forEach((s) => {
                  finalSynonyms.push({ type: ["S", "Q", "O", "U"][index], word: s.trim() });
                });
              }
            });
          });

          let tableHTML = `<p><b>Selected Word:</b> <span id="selected-word">${selectedWord}</span></p>
          <form id="synonymForm">
          <table id="synonymTable" class="styled-table">
          <thead><tr><th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th></tr></thead>
          <tbody>`;

          finalSynonyms.forEach((syn) => {
            tableHTML += `<tr>
            <td><input type="checkbox" name="S" value="${syn.word}" ${syn.type === "S" ? "checked" : ""}></td>
            <td><input type="checkbox" name="Q" value="${syn.word}" ${syn.type === "Q" ? "checked" : ""}></td>
            <td><input type="checkbox" name="O" value="${syn.word}" ${syn.type === "O" ? "checked" : ""}></td>
            <td><input type="checkbox" name="U" value="${syn.word}" ${syn.type === "U" ? "checked" : ""}></td>
            <td>${syn.word}</td>
            </tr>`;
          });

          tableHTML += `</tbody></table><button type="submit" id="submitSynonyms">Submit</button></form>`;
          $("#symptom-details2").html(tableHTML);

          greenWords = new Set([...greenWords, ...res.synonyms.map((s) => s.word.toLowerCase())]);

          $(".synonym-word").each(function () {
            if (greenWords.has($(this).attr("data-word").toLowerCase())) $(this).addClass("green");
          });
        } else {
          $("#symptom-details2").html(`<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`);
        }
      },
    });
  });

  // Handle form submission
  $(document).on("submit", "#synonymForm", function (event) {
    event.preventDefault();
    if (!selectedWord.trim()) return alert("Error: Selected word is empty.");

    let synonyms = { S: [], Q: [], O: [], U: [] };

    $("#synonymTable tbody tr").each(function () {
      let synonymText = $(this).find("td:last").text().trim();
      ["S", "Q", "O", "U"].forEach((type, index) => {
        if ($(this).find(`td:eq(${index}) input`).is(":checked")) synonyms[type].push({ word: synonymText });
      });
    });

    $.ajax({
      url: "update_synonym.php",
      type: "POST",
      data: { word: selectedWord, synonyms: JSON.stringify(synonyms) },
      success: function (response) {
        let res = JSON.parse(response);
        alert(res.message);
      },
    });
  });

  // Handle double-click to toggle stop word status
  $(document).on("dblclick", ".synonym-word, .stopword", function (event) {
    event.preventDefault();
    let word = $(this).attr("data-word");
    let isStopword = $(this).hasClass("stopword");
    let url = isStopword ? "remove_filler_word.php" : "add_filler_word.php";
    let newClass = isStopword ? "synonym-word" : "stopword";

    $.ajax({
      url: url,
      type: "POST",
      data: { word: word },
      success: function (response) {
        let res = JSON.parse(response);
        if (res.success) {
          $(this).toggleClass("synonym-word stopword");
        }
      }.bind(this),
    });
  });

  // Link selected words
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

  // Detect Ctrl + K to link words
  $(document).keydown(function (event) {
    if (event.ctrlKey && event.key === "k") {
      event.preventDefault();
      linkSelectedWords();
    }
  });

  // Right-click to link words
  $(document).on("contextmenu", function (event) {
    event.preventDefault();
    linkSelectedWords();
  });
});