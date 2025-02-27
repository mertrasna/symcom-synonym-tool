function fetchSynonyms(selectedWord) {
  $.ajax({
    url: "search_synonym.php",
    type: "POST",
    data: { word: selectedWord },
    dataType: "json",
    success: function (res) {
      if (res.success) {
        let finalSynonyms = [];
        res.synonyms.forEach((syn) => {
          ["synonym", "cross_reference", "generic_term", "sub_term"].forEach(
            (key, index) => {
              if (syn[key]) {
                syn[key].split(",").forEach((s) => {
                  finalSynonyms.push({
                    type: ["S", "Q", "O", "U"][index],
                    word: s.trim(),
                  });
                });
              }
            }
          );
        });
        fetchRootWord(selectedWord, finalSynonyms);
      } else {
        $("#symptom-details2").html(
          `<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (search_synonym.php):", status, error);
    },
  });
}

function fetchRootWord(selectedWord, finalSynonyms) {
  $.ajax({
    url: "fetch_root_word.php",
    type: "POST",
    data: { word: selectedWord },
    dataType: "json",
    success: function (rootRes) {
      let rootWordHTML =
        rootRes.success && rootRes.word
          ? `<span id="root-word-container">
       <span id="root-word-display">${rootRes.word}</span>
       <button type="button" id="edit-root-word" style="cursor:pointer; margin-left:5px;">Edit</button>
     </span>`
          : `<input type="text" id="root-word" value="${selectedWord}" 
      placeholder="Enter root word..." style="padding: 5px; border: 1px solid #ccc; border-radius: 5px; width: 200px;">`;

      // Build the ENTIRE form, table, checkbox, submit button, and modal
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
                    <td><input type="checkbox" name="S" value="${syn.word}" ${
          syn.type === "S" ? "checked" : ""
        }></td>
                    <td><input type="checkbox" name="Q" value="${syn.word}" ${
          syn.type === "Q" ? "checked" : ""
        }></td>
                    <td><input type="checkbox" name="O" value="${syn.word}" ${
          syn.type === "O" ? "checked" : ""
        }></td>
                    <td><input type="checkbox" name="U" value="${syn.word}" ${
          syn.type === "U" ? "checked" : ""
        }></td>
                    <td>${syn.word}</td>
                  </tr>`;
      });

      // Close the table, then add the Not Sure checkbox, Submit button, and the modal
      tableHTML += `
                </tbody>
              </table>
              <div>
                  <input type="checkbox" id="notSureCheckbox"> Not Sure
              </div>
              <button type="submit" id="submitSynonyms">Submit</button>
            </form>

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
            </div>`;

      // Inject the entire HTML into #symptom-details2
      $("#symptom-details2").html(tableHTML);
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (fetch_root_word.php):", status, error);
    },
  });
}

function submitSynonyms(selectedWord) {
  let rootWord = $("#root-word").val() || $("#root-word").text().trim();
  let synonyms = { S: [], Q: [], O: [], U: [] };

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
    },
    dataType: "json",
    success: function (res) {
      alert(res.message);
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (update_synonym.php):", status, error);
    },
  });
}

function toggleStopwordStatus(element) {
  let word = element.attr("data-word");
  let url = element.hasClass("stopword")
    ? "remove_filler_word.php"
    : "add_filler_word.php";

  $.ajax({
    url: url,
    type: "POST",
    data: { word: word },
    success: function (response) {
      let res = JSON.parse(response);
      if (res.success) {
        element.toggleClass("synonym-word stopword");
      }
    },
  });
}

// Event Listener for Fetching Synonyms
$(document).on("click", ".synonym-word", function () {
  let selectedWord = $(this).attr("data-word").trim();
  fetchSynonyms(selectedWord);
});

// Switch to edit mode when the Edit button is clicked.
$(document).on("click", "#edit-root-word", function () {
  var currentText = $("#root-word-display").text().trim();
  var editHtml = `
      <input type="text" id="root-word-input" value="${currentText}" 
        placeholder="Enter root word..." style="padding:5px; border:1px solid #ccc; border-radius:5px; width:200px;">
      <button type="button" id="save-root-word" style="cursor:pointer; margin-left:5px;">Save</button>
    `;
  $("#root-word-container").html(editHtml);
});

// Save the updated root word and revert back to display mode.
$(document).on("click", "#save-root-word", function () {
  var newText = $("#root-word-input").val().trim();
  if (newText === "") {
    alert("Root word cannot be empty");
    return;
  }
  var displayHtml = `
      <span id="root-word-display">${newText}</span>
      <button type="button" id="edit-root-word" style="cursor:pointer; margin-left:5px;">Edit</button>
    `;
  $("#root-word-container").html(displayHtml);
});
