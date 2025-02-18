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
  
    // Handle clicking on synonym words & stopwords
    $(document).on("click", ".synonym-word, .stopword", function () {
        selectedWord = $(this).attr("data-word").trim();
        console.log("Selected Word:", selectedWord);
  
        if (selectedWord) {
            let korrekturenURL = `https://www.korrekturen.de/synonyme/${encodeURIComponent(selectedWord)}/`;
            $("#korrekturen-btn").attr("href", korrekturenURL);
            $("#korrekturen-btn").text(`🔎 Check korrekturen for "${selectedWord}"`);
        }
    });
  
    // Ensure the form structure exists before updating synonyms
    if (!$("#synonymForm").length) {
        $("#symptom-details2").html(`
          <form id="synonymForm">
            <div id="synonymTableContainer">
              <p>Select a synonym to see results here.</p>
            </div>
            <div>
              <input type="checkbox" id="notSureCheckbox"> Not Sure
            </div>
            <button type="submit" id="submitSynonyms">Submit</button>
          </form>
        `);
    }
  
    // Handle clicking to fetch synonyms (Only updates the table)
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
  
                            tableHTML += `</tbody></table>`;
  
                            $("#synonymTableContainer").html(tableHTML);
  
                        },
                        error: function (xhr, status, error) {
                            console.error("AJAX Error (fetch_root_word.php):", status, error);
                        }
                    });
  
                } else {
                    $("#synonymTableContainer").html(`<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error (search_synonym.php):", status, error);
            }
        });
    });
  
    // Handle form submission
    // Handle form submission
$(document).on("submit", "#synonymForm", function (event) {
    event.preventDefault();
    let selectedWord = $("#selected-word").text().trim();
    if (!selectedWord) {
        alert("Error: Selected word is empty.");
        return;
    }

    // Gather synonyms
    let synonyms = { S: [], Q: [], O: [], U: [] };
    $("#synonymTable tbody tr").each(function () {
        let synonymText = $(this).find("td:last").text().trim();
        ["S", "Q", "O", "U"].forEach((type, index) => {
            if ($(this).find(`td:eq(${index}) input`).is(":checked")) {
                synonyms[type].push({ word: synonymText });
            }
        });
    });

    // Also gather root word and comment if needed
    let rootWord = $("#root-word").val() || $("#root-word").text().trim();
    let comment = $('#notSureCheckbox').prop('checked') ? $('#commentText').val().trim() : '';

    // Send AJAX update
    $.ajax({
        url: "update_synonym.php",
        type: "POST",
        data: {
            word: selectedWord,
            root_word: rootWord,
            synonyms: JSON.stringify(synonyms),
            comment: comment // if you want to include comments
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

// ✅ Use event delegation so it works for dynamically added elements
$(document).on("change", "#notSureCheckbox", function() {
    if (this.checked) {
        $("#commentModal").show();
    } else {
        $("#commentText").val('');
    }
});

// ✅ Close modal and keep checkbox checked
$(document).on("click", "#saveComment", function() {
    $("#commentModal").hide();
});

// ✅ Allow closing the modal
$(document).on("click", ".close-modal, #closeComment", function() {
    $("#commentModal").hide();
    $("#notSureCheckbox").prop("checked", false);
});


  
    // Handle double-click to toggle stop word status
    $(document).on("dblclick", ".synonym-word, .stopword", function (event) {
        event.preventDefault();
        let word = $(this).attr("data-word");
        let isStopword = $(this).hasClass("stopword");
        let url = isStopword ? "remove_filler_word.php" : "add_filler_word.php";
  
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
  
  });
  