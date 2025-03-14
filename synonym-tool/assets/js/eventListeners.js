const symptomsPerPage = 200;
let greenWords = new Set();
let selectedWord = "";

$(document).ready(function () {
  // Update URL with new offset and reload page
  function updateUrlWithOffset(newOffset) {
    const url = new URL(window.location.href);
    url.searchParams.set("offset", newOffset);
    window.location.href = url.toString(); // Reload with updated offset
  }

  // "Reload New Symptoms" button click (offset +200)
  $(document).on("click", "#reloadSymptoms", function () {
    let currentOffset =
      parseInt(new URLSearchParams(window.location.search).get("offset")) || 0;
    currentOffset += symptomsPerPage; // Increment by 200 each click
    updateUrlWithOffset(currentOffset); // Reload with updated offset
  });

  // "Back to Start" button click (resets offset)
  $(document).on("click", "#resetToStart", function () {
    updateUrlWithOffset(0); // Reset offset to 0 and reload
  });

  $(".symptom-item").click(function () {
    $("#symptom-details").html($(this).html());
  });

  // Handle clicking on synonym words & stopwords
  $(document).on("click", ".synonym-word, .stopword", function () {
    selectedWord = $(this).attr("data-word").trim();
    console.log("Selected Word:", selectedWord);

    if (selectedWord) {
      let korrekturenURL = `https://www.korrekturen.de/synonyme/${encodeURIComponent(
        selectedWord
      )}/`;
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

    // check if the word is already greem (processed)
    const isGreen = $(this).hasClass("green");

    if (!isGreen) {
      // Only call these for new (blue) words
      fetchChatGPTSynonyms(selectedWord);
      fetchKorrekturenSynonyms(selectedWord);
      setTimeout(() => {
        fetchSynonymsFromOpenThesaurus(selectedWord);
      }, 500);
    }

    // Existing AJAX call to fetch synonyms
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

          // Fetch root word
          $.ajax({
            url: "fetch_root_word.php",
            type: "POST",
            data: { word: selectedWord },
            dataType: "json",
            success: function (rootRes) {
              console.log("fetch_root_word.php Response:", rootRes);

              let rootWordHTML =
                rootRes.success && rootRes.word
                  ? `<input type="text" id="root-word" value="${rootRes.word}" 
                    placeholder="Enter root word..." style="padding:5px; border:1px solid #ccc; border-radius:5px; width:200px;">`
                  : `<input type="text" id="root-word" value="${selectedWord}" 
                    placeholder="Enter root word..." style="padding:5px; border:1px solid #ccc; border-radius:5px; width:200px;">`;

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
                                      <td><input type="checkbox" name="S" value="${
                                        syn.word
                                      }" ${
                  syn.type === "S" ? "checked" : ""
                }></td>
                                      <td><input type="checkbox" name="Q" value="${
                                        syn.word
                                      }" ${
                  syn.type === "Q" ? "checked" : ""
                }></td>
                                      <td><input type="checkbox" name="O" value="${
                                        syn.word
                                      }" ${
                  syn.type === "O" ? "checked" : ""
                }></td>
                                      <td><input type="checkbox" name="U" value="${
                                        syn.word
                                      }" ${
                  syn.type === "U" ? "checked" : ""
                }></td>
                                      <td>${syn.word}</td>
                                    </tr>`;
              });

              tableHTML += `</tbody></table>`;

              // Update the table dynamically without refreshing
              $("#synonymTableContainer").html(tableHTML);
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error (fetch_root_word.php):", status, error);
            },
          });
        } else {
          $("#synonymTableContainer").html(
            `<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error (search_synonym.php):", status, error);
      },
    });
  });

  // Fetch synonyms from ChatGPT
  function fetchChatGPTSynonyms(selectedWord) {
    const apiKey = "key"; // <-- Add your OpenAI API key here
    const requestBody = {
      model: "gpt-4",
      messages: [
        { role: "system", content: "You are a helpful assistant." },
        {
          role: "user",
          content: `Give me a list of 5 german synonyms for the word "${selectedWord}"`,
        },
      ],
      max_tokens: 50,
      temperature: 0.7,
    };

    fetch("https://api.openai.com/v1/chat/completions", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${apiKey}`,
      },
      body: JSON.stringify(requestBody),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("OpenAI Response:", data);

        const chatGptResponse = data.choices[0].message.content.trim();
        const synonyms = chatGptResponse.split(",").map((syn) => syn.trim());

        const strictSynonym = synonyms.join(",");

        const synonymData = {
          word: selectedWord,
          synonym: strictSynonym,
          cross_reference: "",
          synonym_partial_2: "",
          generic_term: "",
          sub_term: "",
          synonym_nn: "",
          comment: "",
          non_secure_flag: "1",
          source_reference_ns: "1",
          active: 1,
        };

        // Insert synonym data into the database
        $.ajax({
          url: "insert_synonym.php",
          type: "POST",
          data: synonymData,
          success: function (response) {
            console.log("Insert Synonym Response:", response);
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error (insert_synonym.php):", status, error);
          },
        });
      })
      .catch((error) => {
        console.error("OpenAI API Error:", error);
      });
  }

  /**
   * Main function that fetches synonyms via PHP + fallback
   * If fewer than 1 synonyms found, or "Keine Synonyme gefunden." is present,
   * we skip entirely.
   */
  function fetchKorrekturenSynonyms(selectedWord) {
    console.log(
      `🔎 Fetching synonyms from Korrekturen.de for: ${selectedWord}`
    );
    selectedWord = selectedWord.trim().replace(/,$/, "");

    $.ajax({
      url: "scrape_korrekturen.php", // Calls PHP scraper directly
      type: "GET",
      data: { word: selectedWord },
      dataType: "json",
      success: function (response) {
        if (!response.success) {
          console.log(`ℹ️ No synonyms found for '${selectedWord}'.`);
          return;
        }

        let html = response.html;
        console.log("HTML successfully fetched from Korrekturen.de.");

        // Check if no synonyms were found
        if (html.includes("Keine Synonyme gefunden.")) {
          console.log(
            `ℹ️ No synonyms available for '${selectedWord}'. from Korrekturen.de.`
          );
          return;
        }

        let parser = new DOMParser();
        let doc = parser.parseFromString(html, "text/html");

        // Extract synonyms
        let synonymElements = doc.querySelectorAll("a.synonyme");
        let synonymList = [];

        synonymElements.forEach((el) => {
          let synonym = el.innerText
            .replace(/\(.*?\)/g, "") // Remove (ugs.), etc.
            .replace(/\[.*?\]/g, "") // Remove [☯ Gegensatz...]
            .replace(/\[☯ Gegensatz:.*?\]/g, "")
            .replace(/[•.,]/g, "") // Remove bullets, commas, etc.
            .replace(/\s+/g, " ") // Collapse extra spaces
            .trim();

          if (synonym.length > 1 && !synonymList.includes(synonym)) {
            synonymList.push(synonym);
          }
        });

        if (synonymList.length === 0) {
          console.log(`ℹ️ No valid synonyms extracted for '${selectedWord}'.`);
          return;
        }

        const strictSynonym = synonymList.join(",");

        const synonymData = {
          word: selectedWord,
          synonym: strictSynonym,
          cross_reference: "",
          synonym_partial_2: "",
          generic_term: "",
          sub_term: "",
          synonym_nn: "",
          comment: "",
          non_secure_flag: "1",
          source_reference_ns: "1",
          active: 1,
        };

        // Insert synonyms into the database
        console.log("Preparing to insert synonyms:", synonymData);

        // Insert synonym data into the database
        $.ajax({
          url: "insert_synonym.php",
          type: "POST",
          data: synonymData,
          success: function (response) {
            console.log("Insert Synonym Response (Korrekturen.de):", response);
          },
          error: function (xhr, status, error) {
            console.error(
              "AJAX Error (insert_synonym.php - Korrekturen.de):",
              status,
              error
            );
          },
        });
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error (scrape_korrekturen.php):", status, error);
      },
    });
  }



function addSynonymsToTable(word, synonyms) {
  if (!synonyms || synonyms.length === 0) {
      return; // ⛔ No synonyms provided, do nothing
  }

  let existingSynonyms = new Set();

  // Collect existing synonyms from the table
  $("#synonymTable tbody tr").each(function () {
      let synonymText = $(this).find("td:last").text().trim().toLowerCase();
      existingSynonyms.add(synonymText);
  });

  // Filter out already existing synonyms
  let newSynonyms = synonyms.filter((syn) => {
      let cleanSyn = syn.trim().toLowerCase();
      return cleanSyn.length > 1 && !existingSynonyms.has(cleanSyn);
  });

  if (newSynonyms.length === 0) {
      return; // ⛔ All synonyms were duplicates, do nothing
  }

  // Limit synonyms to 7
  if (newSynonyms.length > 7) {
      newSynonyms = newSynonyms.slice(0, 7);
  }

    // Create new table rows for each synonym
    let newRows = newSynonyms.map(syn => `
        <tr>
            <td><input type="checkbox" name="S" value="${syn}"></td>
            <td><input type="checkbox" name="Q" value="${syn}"></td>
            <td><input type="checkbox" name="O" value="${syn}"></td>
            <td><input type="checkbox" name="U" value="${syn}"></td>
            <td>${syn}</td>
        </tr>
    `).join("");

    console.log("📝 Adding New Rows to Table:", newRows);

    // Ensure the tbody is present before appending rows
    $("#synonymTable tbody").append(newRows);

    console.log("Synonyms successfully added!");
  }





  function removeDuplicateSynonyms(korrekturenSynonyms) {
    console.log("🔍 Checking for duplicates...");

    let existingSynonyms = new Set();

    // Collect existing synonyms from the table
    $("#synonymTable tbody tr").each(function () {
      let synonymText = $(this).find("td:last").text().trim();
      existingSynonyms.add(synonymText.toLowerCase());
    });

    console.log(" Existing Synonyms in Table:", Array.from(existingSynonyms));

    let uniqueSynonyms = korrekturenSynonyms.filter(
      (syn) => !existingSynonyms.has(syn.toLowerCase())
    );
    console.log("Unique Synonyms to Add:", uniqueSynonyms);

    let currentCount = $("#synonymTable tbody tr").length;
    let maxTotal = 10; // <-- TOTAL synonyms allowed in the table
    let maxPerBatch = 7; // <-- Only add up to 7 synonyms from this fetch

    if (currentCount >= maxTotal) {
      console.warn(
        "⚠️ The table already has 15 synonyms. Not adding any more."
      );
      return;
    }

    //  The total space left to reach 15
    let spaceLeft = maxTotal - currentCount;
    console.log(
      `ℹSynonyms in table: ${currentCount}. Space left for total of 15: ${spaceLeft}.`
    );
    let finalLimit = Math.min(spaceLeft, maxPerBatch);
    console.log(` We can add at most ${finalLimit} synonyms from this batch.`);
    let synonymsToAdd = uniqueSynonyms.slice(0, finalLimit);
    console.log(" Synonyms to actually add:", synonymsToAdd);

    // 7) If none remain, do nothing
    if (synonymsToAdd.length === 0) {
      console.warn(
        "⚠️ No new synonyms added (all were duplicates or limit reached)."
      );
      return;
    }

    // 8) Build table rows
    let newRows = synonymsToAdd
      .map(
        (syn) => `
      <tr>
          <td><input type="checkbox" name="S" value="${syn}"></td>
          <td><input type="checkbox" name="Q" value="${syn}"></td>
          <td><input type="checkbox" name="O" value="${syn}"></td>
          <td><input type="checkbox" name="U" value="${syn}"></td>
          <td>${syn}</td>
      </tr>
  `
      )
      .join("");

    console.log("📝 Adding New Rows to Table:", newRows);

    $("#synonymTable tbody").append(newRows);
    console.log("✅ Synonyms added successfully!");
  }

  // Function to fetch Synonyms from OpenThesaurus.de
  function fetchSynonymsFromOpenThesaurus(selectedWord) {
    console.log(
      `🔎 Fetching synonyms from OpenThesaurus.de for: ${selectedWord}`
    );
    selectedWord = selectedWord.trim().replace(/,$/, "");

    const apiUrl = `https://www.openthesaurus.de/synonyme/search?q=${encodeURIComponent(
      selectedWord
    )}&format=application/json`;

    $.ajax({
      url: apiUrl,
      type: "GET",
      dataType: "json",
      success: function (response) {
        console.log("OpenThesaurus.de Response:", response);

        let thesaurusSynonyms = [];

        if (response.synsets && response.synsets.length > 0) {
          response.synsets.forEach((set) => {
            if (set.terms && set.terms.length > 0) {
              set.terms.forEach((term) => {
                let cleanedWord = term.term.replace(/\([^)]*\)/g, "").trim();
                if (cleanedWord && !thesaurusSynonyms.includes(cleanedWord)) {
                  thesaurusSynonyms.push(cleanedWord);
                }
              });
            }
          });
        }

        if (thesaurusSynonyms.length === 0) {
          console.log(
            `ℹ️ No synonyms found for '${selectedWord}' on OpenThesaurus.de.`
          );
          return;
        }

        console.log(`Found synonyms from OpenThesaurus.de:`, thesaurusSynonyms);

        // Add the synonyms to the table
        addSynonymsToTable(selectedWord, thesaurusSynonyms);

        // Create a properly formatted synonym string
        const strictSynonym = thesaurusSynonyms.join(",");

        // Create the data object to send to the server
        const synonymData = {
          word: selectedWord,
          synonym: strictSynonym,
          cross_reference: "",
          synonym_partial_2: "",
          generic_term: "",
          sub_term: "",
          synonym_nn: "",
          comment: "",
          non_secure_flag: "1",
          source_reference_ns: "1",
          active: "1",
        };

        console.log("Sending data to insert_synonym.php:", synonymData);

        // Insert synonyms into the database with improved error handling
        $.ajax({
          url: "insert_synonym.php",
          type: "POST",
          data: synonymData,
          dataType: "json",
          success: function (response) {
            console.log(
              "Insert Synonym Response (OpenThesaurus.de):",
              response
            );
            if (response.success) {
              console.log(
                "✅ Successfully saved OpenThesaurus synonyms for:",
                selectedWord
              );
            } else {
              console.warn("⚠️ Error saving synonyms:", response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error(
              "AJAX Error (insert_synonym.php - OpenThesaurus.de):",
              status,
              error
            );
            console.error("Response Text:", xhr.responseText);

            // Try to parse the error response if possible
            try {
              const errorDetails = JSON.parse(xhr.responseText);
              console.error("Error Details:", errorDetails);
            } catch (e) {
              console.error("Unable to parse error response");
            }
          },
        });
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error (OpenThesaurus.de API):", status, error);
      },
    });
  }


  // Click the next clickable word (blue or green) in the sentence
  function clickNextClickableWord() {
    let clickableWords = $(".synonym-word, .synonym-word.green");
    let currentIndex = clickableWords.index(
      $(`.synonym-word[data-word='${selectedWord}']`)
    );
    if (currentIndex !== -1 && currentIndex < clickableWords.length - 1) {
      clickableWords.eq(currentIndex + 1).trigger("click");
    } else {
      alert(
        "No more clickable words in this symptom.\\nProcessing completed for this symptom."
      );
    }
  }

  // ✅ Use event delegation so it works for dynamically added elements
  $(document).on("change", "#notSureCheckbox", function () {
    if (this.checked) {
      $("#commentModal").show();
    } else {
      $("#commentText").val("");
    }
  });

  // ✅ Close modal and keep checkbox checked
  $(document).on("click", "#saveComment", function () {
    $("#commentModal").hide();
  });

  // ✅ Allow closing the modal
  $(document).on("click", ".close-modal, #closeComment", function () {
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

  $(document).on("change", "#synonymTable tbody input[type='checkbox']", function () {
    let row = $(this).closest("tr"); // Find the current row
    row.find("input[type='checkbox']").not(this).prop("checked", false); // Uncheck others
  });
});

// Handle form submission
$(document).on("submit", "#synonymForm", function (event) {
  event.preventDefault();
  if (!selectedWord.trim()) {
    alert("Error: Selected word is empty.");
    return;
  }

  let rootWord = $("#root-word").val() || $("#root-word").text().trim();
  console.log("Submitting Root Word:", rootWord);

  // Collect all synonym categorizations
  let synonyms = { S: [], Q: [], O: [], U: [] };
  let comment = $("#notSureCheckbox").prop("checked")
    ? $("#commentText").val().trim()
    : "";

  // Collect checked checkboxes
  $("#synonymTable tbody tr").each(function () {
    let synonymText = $(this).find("td:last").text().trim();

    // Check each checkbox in the row
    $(this)
      .find('input[type="checkbox"]')
      .each(function (index) {
        if ($(this).is(":checked")) {
          let category = ["S", "Q", "O", "U"][index];
          synonyms[category].push({ word: synonymText });
          console.log(`Adding ${synonymText} to category ${category}`);
        }
      });
  });

  console.log("Collected synonyms:", synonyms);

  // Submit the data to the server
  $.ajax({
    url: "update_synonym.php",
    type: "POST",
    data: {
      word: selectedWord,
      root_word: rootWord,
      synonyms: JSON.stringify(synonyms),
      comment: comment,
    },
    dataType: "json",
    success: function (res) {
      console.log("Update response:", res);

      if (res.success) {
        alert(res.message);

        // Update UI to reflect saved state
        $(`.synonym-word[data-word="${selectedWord}"]`).addClass("green");

        // Optional: Move to next word automatically
        // clickNextClickableWord();
      } else {
        alert("Error: " + res.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (update_synonym.php):", status, error);
      console.error("Response Text:", xhr.responseText);
      alert("Error updating synonyms. Check console for details.");
    },
  });
});

$(document).ready(function () {
  $(document).on("click", ".synonym-word", function () {
    let selectedWord = $(this).attr("data-word").trim();
    console.log("Selected Word:", selectedWord);

    $.ajax({
      url: "search_synonym.php",
      type: "POST",
      data: { word: selectedWord },
      dataType: "json",
      success: function (res) {
        console.log("search_synonym.php Response:", res);

        if (!res.success || !res.synonyms.length) {
          $("#synonymTableContainer").html(
            `<p style='color:red;'>No synonyms found for ${selectedWord}.</p>`
          );

          // Show the Wörterbuchnetz button dynamically
          let woerterbuchnetzURL = `https://www.woerterbuchnetz.de`;

          $("#woerterbuchnetz-btn").attr("href", woerterbuchnetzURL);
          $("#woerterbuchnetz-btn").text(`🔎 Search in Wörterbuchnetz.`);
          $("#woerterbuchnetz-container").show(); // Show the button
        } else {
          $("#woerterbuchnetz-container").hide(); // Hide if synonyms exist
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error (search_synonym.php):", status, error);
      },
    });
  });
});
