function fetchSynonyms(selectedWord) {
  // Show loading indicator
  $("#symptom-details2").html("<p>Loading synonyms...</p>");

  // Get master ID from URL
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid") || 5075; // Default to English

  $.ajax({
    url: "search_synonym.php",
    type: "POST",
    data: {
      word: selectedWord,
      master_id: mid,
    },
    dataType: "json",
    success: function (res) {
      console.log("Synonym search response:", res);

      if (res.success && res.synonyms && res.synonyms.length > 0) {
        // Use our new deduplication function instead of direct processing
        let finalSynonyms = [];

        res.synonyms.forEach((syn) => {
          // Apply deduplication to each synonym record
          const processedSynonyms = processSynonymsWithDeduplication(syn);
          finalSynonyms = finalSynonyms.concat(processedSynonyms);
        });

        // Fetch root word after synonym search succeeds
        fetchRootWord(selectedWord, finalSynonyms);

        // Check if word has a Not Sure flag
        if (res.non_secure_flag == 1) {
          $("#notSureCheckbox").prop("checked", true);
        } else {
          $("#notSureCheckbox").prop("checked", false);
        }
      } else {
        $("#symptom-details2").html(
          `<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (search_synonym.php):", status, error);
      $("#symptom-details2").html(
        `<p style='color:red;'>Error fetching synonyms: ${error}</p>`
      );
    },
  });
}

/**
 * Process synonyms from the backend response and prevent duplicates across categories
 * @param {Object} synonymData - The synonym data from the response
 * @return {Array} - Processed array of synonym objects with deduplication
 */
function processSynonymsWithDeduplication(synonymData) {
  let finalSynonyms = [];
  let seenWords = new Set(); // Track words we've already processed

  const categories = [
    { key: "synonym", type: "S" },
    { key: "cross_reference", type: "Q" },
    { key: "generic_term", type: "O" },
    { key: "sub_term", type: "U" },
  ];

  // Process categories in order of priority (S, Q, O, U)
  categories.forEach((category) => {
    if (synonymData[category.key]) {
      synonymData[category.key].split(",").forEach((word) => {
        const trimmedWord = word.trim();
        // Only add the word if we haven't seen it before
        if (trimmedWord && !seenWords.has(trimmedWord.toLowerCase())) {
          seenWords.add(trimmedWord.toLowerCase());
          finalSynonyms.push({
            type: category.type,
            word: trimmedWord,
          });
        }
      });
    }
  });

  return finalSynonyms;
}

function fetchRootWord(selectedWord, finalSynonyms) {
  // Extract 'mid' from the URL (or set it by some other means)
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid") || 5075; // This will be "5072" for German if in URL

  $.ajax({
    url: "fetch_root_word.php",
    type: "POST",
    data: {
      word: selectedWord,
      master_id: mid, // Include master_id so the server queries the correct table
    },
    dataType: "json",
    success: function (rootRes) {
      console.log("fetch_root_word.php Response:", rootRes);

      let rootWordHTML =
        rootRes.success && rootRes.word
          ? '<input type="text" id="root-word" value="' +
            rootRes.word.replace(/[^\w\s]/g, "") + 
            '" placeholder="Enter root word..." style="padding:5px; border:1px solid #ccc; border-radius:5px; width:200px;">'
          : '<input type="text" id="root-word" value="' +
            selectedWord.replace(/[^\w\s]/g, "") + 
            '" placeholder="Enter root word..." style="padding:5px; border:1px solid #ccc; border-radius:5px; width:200px;">';

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

      //  empty row for manual entry
      tableHTML += `
        <tr>
          <td><input type="checkbox" name="S" id="manualS"></td>
          <td><input type="checkbox" name="Q" id="manualQ"></td>
          <td><input type="checkbox" name="O" id="manualO"></td>
          <td><input type="checkbox" name="U" id="manualU"></td>
          <td><input type="text" id="manualSynonym" placeholder="Enter new synonym..." style="width: 100%;"></td>
        </tr>`;

      tableHTML += `</tbody></table>
              <div style="display: flex; align-items: center; margin-top: 10px;">
                <div style="margin-right: 20px;">
                  <input type="checkbox" id="notSureCheckbox"> Not Sure
                </div>
                <button type="button" id="newAssignmentBtn" style="background-color: #6c757d; color: white; border: none; border-radius: 4px; padding: 5px 10px; cursor: pointer;">New Assignment</button>
                <button id="toggleAllSBtn" type="button">Toggle All S</button>
                <button id="addNoteBtn" type="button" style="background-color: #28a745; color: white; border: none; border-radius: 4px; padding: 5px 10px; margin-left: 10px; cursor: pointer;">📝 Note</button>
                <button id="viewNoteBtn" type="button" style="background-color: #17a2b8; color: white; border: none; border-radius: 4px; padding: 5px 10px; margin-left: 10px; cursor: pointer;">👁 View Note</button>
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

      $("#symptom-details2").html(tableHTML);
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (fetch_root_word.php):", status, error);
    },
  });
}

function submitSynonyms(selectedWord) {
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid"); // e.g. "5075"

  selectedWord = selectedWord.trim();
  if (!selectedWord) {
    alert("Error: No word selected for synonym submission.");
    return;
  }

  let rootWord = $("#root-word").val() || $("#root-word").text().trim();
  let synonyms = { S: [], Q: [], O: [], U: [] };

  //  Loop through all synonyms in the table and collect them
  $("#synonymTable tbody tr").each(function () {
    let synonymText = $(this).find("td:last").text().trim();
    ["S", "Q", "O", "U"].forEach((type, index) => {
      if ($(this).find(`td:eq(${index}) input`).is(":checked")) {
        synonyms[type].push(synonymText); //  Store as string
      }
    });
  });

  //  Capture manually entered synonym
  let manualSynonymText = $("#manualSynonym").val().trim();
  let manualSynonymType = [];

  //  Capture selected checkbox types for manual synonym
  ["S", "Q", "O", "U"].forEach((type, index) => {
    if ($(`#manual${type}`).is(":checked")) {
      manualSynonymType.push(type);
    }
  });

  //  If the user entered a manual synonym but didn't select any type, alert them
  if (manualSynonymText && manualSynonymType.length === 0) {
    alert(
      "Please select at least one category (S, Q, O, or U) for the manual synonym."
    );
    return;
  }

  //  If a manual synonym is entered, add it to the respective categories
  manualSynonymType.forEach((type) => {
    synonyms[type].push(manualSynonymText); //  Push as a string
  });

  //  Log the data before sending to the server
  console.log("🔍 Submitting Synonyms Data:", {
    word: selectedWord,
    root_word: rootWord,
    synonyms: synonyms,
    manual_synonym: manualSynonymText,
    manual_synonym_types: manualSynonymType,
    master_id: mid,
  });

  //  Send the data via AJAX
  $.ajax({
    url: "update_synonym.php",
    type: "POST",
    data: {
      word: selectedWord,
      root_word: rootWord,
      synonyms: JSON.stringify(synonyms),
      manual_synonym: manualSynonymText,
      manual_synonym_types: JSON.stringify(manualSynonymType),
      master_id: mid,
    },
    dataType: "json",
    success: function (res) {
      alert(res.message);
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (update_synonym.php):", status, error);
      console.error("Server Response:", xhr.responseText);
    },
  });
}

// Function to toggle stopword status by sending the word and masterId to the backend.
function toggleStopwordStatus(element) {
  let word = element.attr("data-word");
  let url = element.hasClass("stopword")
    ? "remove_filler_word.php"
    : "add_filler_word.php";

  $.ajax({
    url: url,
    type: "POST",
    data: { word: word, master_id: masterId },
    success: function (response) {
      let res = JSON.parse(response);
      if (res.success) {
        element.toggleClass("synonym-word stopword");
      }
    },
  });
}

// Event Listener for Fetching Synonyms (click on a synonym-word)
$(document).on("click", ".synonym-word", function () {
  let selectedWord = $(this).attr("data-word").trim();
  console.log("Selected Word:", selectedWord);
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
