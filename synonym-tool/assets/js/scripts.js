$(document).ready(function () {
  let greenWords = new Set();

  // Toggle left-right pane view
  $("#toggleView").click(function () {
      $(".left-pane").toggle();
      $(".right-pane").css("width", $(".left-pane").is(":visible") ? "70%" : "100%");
      $(this).text($(".left-pane").is(":visible") ? "⇦" : "⇨");
  });

  $(".symptom-item").click(function () {
      $("#symptom-details").html($(this).html());
  });

  let selectedWord = "";

  // Handle clicking on synonym words & stopwords (Added function for korrekturen search)
  $(document).on("click", ".synonym-word, .stopword", function () {
      selectedWord = $(this).attr("data-word").trim();
      console.log("Selected Word:", selectedWord);

      if (selectedWord) {
          let korrekturenURL = `https://www.korrekturen.de/synonyme/${encodeURIComponent(selectedWord)}/`;
          $("#korrekturen-btn").attr("href", korrekturenURL);
          $("#korrekturen-btn").text(`🔎 Check korrekturen for "${selectedWord}"`);
      }
  });

  // Handle clicking to fetch synonyms
  $(document).on("click", ".synonym-word", function () {
      selectedWord = $(this).attr("data-word").trim();
      console.log("Selected Word:", selectedWord);

      $.ajax({
          url: "search_synonym.php",
          type: "POST",
          data: { word: selectedWord },
          dataType: "json",
          success: function (res) {
              console.log("search_synonym.php Response:", res);

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

                  // Fetch root word
                  $.ajax({
                      url: "fetch_root_word.php",
                      type: "POST",
                      data: { word: selectedWord },
                      dataType: "json",
                      success: function (rootRes) {
                          console.log("fetch_root_word.php Response:", rootRes);

                          let rootWordHTML = rootRes.success && rootRes.word
                              ? `<span id="root-word">${rootRes.word}</span>`
                              : `<input type="text" id="root-word" value="${selectedWord}" 
                                placeholder="Enter root word..." style="padding: 5px; border: 1px solid #ccc; border-radius: 5px; width: 200px;">`;

                          let tableHTML = `
                          <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; margin-bottom: 10px;">
                              <p><b>Selected Word:</b> <span id="selected-word">${selectedWord}</span></p>
                              <p><b>Root Word:</b> ${rootWordHTML}</p>
                          </div>

                          <form id="synonymForm">
                            <table id="synonymTable" class="styled-table">
                              <thead>
                                <tr>
                                  <th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th>
                                </tr>
                              </thead>
                              <tbody>`;

                          finalSynonyms.forEach((syn) => {
                              tableHTML += `
                                    <tr>
                                      <td><input type="checkbox" name="S" value="${syn.word}" ${syn.type === "S" ? "checked" : ""}></td>
                                      <td><input type="checkbox" name="Q" value="${syn.word}" ${syn.type === "Q" ? "checked" : ""}></td>
                                      <td><input type="checkbox" name="O" value="${syn.word}" ${syn.type === "O" ? "checked" : ""}></td>
                                      <td><input type="checkbox" name="U" value="${syn.word}" ${syn.type === "U" ? "checked" : ""}></td>
                                      <td>${syn.word}</td>
                                    </tr>`;
                          });

                          tableHTML += `
                              </tbody>
                            </table>
                            <div>
                            <input type="checkbox" id="notSureCheckbox"> Not Sure
                            <!-- The comment section is now removed from here -->
                        </div>
                        <!-- Comment Box Modal -->
<div id="commentModal" class="modal" style="display:none;">
    <div class="modal-content" style="position: relative; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 300px; background: #fff;">
        <span class="close-modal" style="position: absolute; right: 10px; top: 5px; cursor: pointer; font-size: 20px;">&times;</span>
        <h3>Enter your comment</h3>
        <textarea id="commentText" placeholder="Enter reason for uncertainty..." rows="3" cols="30"></textarea>
        <br>
        <button id="saveComment">Save</button>
        <button id="closeComment">Close</button>
    </div>
</div>
                            <button type="submit" id="submitSynonyms">Submit</button>
                          </form>`;

                          $("#symptom-details2").html(tableHTML);

                          greenWords = new Set([...greenWords, ...res.synonyms.map((s) => s.word.toLowerCase())]);

                          $(".synonym-word").each(function () {
                              if (greenWords.has($(this).attr("data-word").toLowerCase())) $(this).addClass("green");
                          });
                      },
                      error: function (xhr, status, error) {
                          console.error("AJAX Error (fetch_root_word.php):", status, error);
                      }
                  });

              } else {
                  $("#symptom-details2").html(`<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`);
              }
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error (search_synonym.php):", status, error);
          }
      });
  });

  // Handle form submission
  $(document).on("submit", "#synonymForm", function (event) {
      event.preventDefault();
      if (!selectedWord.trim()) return alert("Error: Selected word is empty.");

      let rootWord = $("#root-word").val() || $("#root-word").text().trim();
      console.log("Submitting Root Word:", rootWord);

      let synonyms = { S: [], Q: [], O: [], U: [] };
      let comment = $('#notSureCheckbox').prop('checked') ? $('#commentText').val().trim() : '';

      $("#synonymTable tbody tr").each(function () {
          let synonymText = $(this).find("td:last").text().trim();
          ["S", "Q", "O", "U"].forEach((type, index) => {
              if ($(this).find(`td:eq(${index}) input`).is(":checked")) {
                  synonyms[type].push({ word: synonymText });
              }
          });
      });

      $.ajax({
          url: "update_synonym.php",
          type: "POST",
          data: {
              word: selectedWord,
              root_word: rootWord,
              synonyms: JSON.stringify(synonyms),
              comment: comment // Send comment data if present
          },
          dataType: "json",
          success: function (res) {
              alert(res.message);
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error (update_synonym.php):", status, error);
          }
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

  $(document).keydown(function (event) {
      if (event.ctrlKey && event.key === "k") {
          event.preventDefault();
          linkSelectedWords();
      }
  });

  $(document).on("contextmenu", function (event) {
      event.preventDefault();
      linkSelectedWords();
  });

  $(document).on("change", "#notSureCheckbox", function() {
    if(this.checked){
        $("#commentModal").show();
    } else {
        // If unchecked, you can clear the textarea if needed
        $("#commentText").val('');
    }
});

$(document).on("click", ".close-modal", function() {
    $("#commentModal").hide();
    $("#notSureCheckbox").prop("checked", false);
});

// Optionally, close modal when clicking outside the modal-content
$(document).on("click", function(event) {
    if ($(event.target).is("#commentModal")) {
        $("#commentModal").hide();
        $("#notSureCheckbox").prop("checked", false);
    }
});

$(document).on("click", "#saveComment", function() {
    // You can add any saving logic here if needed
    $("#commentModal").hide();
});





});
