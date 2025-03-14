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


// Handle clicking on synonym words & stopwords
$(document).on("click", ".synonym-word, .stopword", function () {
  selectedWord = $(this).attr("data-word").trim();
  console.log("Selected Word:", selectedWord);

  if (selectedWord) {
    let dictionaryURL = `https://www.dictionary.com/browse/${encodeURIComponent(
      selectedWord
    )}/`;
    $("#dictionary-btn").attr("href", dictionaryURL);
    $("#dictionary-btn").text(`🔎 Check Dictionary for "${selectedWord}"`);
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

    // Extract master id from URL (or default if needed)
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid") || "5075"; // Default to 5075


    if (!isGreen) {
      if (mid === "5075") {
        // For English, use Dictionary.com
        fetchSynonymsFromDictionary(selectedWord);
        // Also, Thesaurus.com
        fetchSynonymsFromThesaurus(selectedWord);
        fetchChatGPTSynonyms(selectedWord);
      } else if (mid === "5072") {
        // For German, use existing sources
        fetchChatGPTSynonyms(selectedWord);
        fetchKorrekturenSynonyms(selectedWord);
        setTimeout(() => {
          fetchSynonymsFromOpenThesaurus(selectedWord);
        }, 500);
      } else {
        console.warn("Unexpected master_id:", mid);
      }
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
            data: {
    word: selectedWord,
    master_id: mid  
  },
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

  // Fetch synonyms from ChatGPT, adjusting for language based on masterId
function fetchChatGPTSynonyms(selectedWord) {
  // Determine the language based on masterId (5072 for German, default to English)
  const language = (masterId === 5072) ? "german" : "english";

  const apiKey = "key"; // <-- Add your OpenAI API key here
  const requestBody = {
    model: "gpt-4",
    messages: [
      { role: "system", content: "You are a helpful assistant." },
      {
        role: "user",
        content: `Give me a list of 5 ${language} synonyms for the word "${selectedWord}"`,
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
        master_id: masterId // Pass the masterId for language-specific processing
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


function fetchKorrekturenSynonyms(selectedWord) {
  console.log(`🔎 Fetching synonyms from Korrekturen.de for: ${selectedWord}`);
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
          `ℹ️ No synonyms available for '${selectedWord}' from Korrekturen.de.`
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
          .replace(/[•.,]/g, "")   // Remove bullets, commas, etc.
          .replace(/\s+/g, " ")    // Collapse extra spaces
          .trim();

        if (synonym.length > 1 && !synonymList.includes(synonym)) {
          synonymList.push(synonym);
        }
      });

      if (synonymList.length === 0) {
        console.log(`ℹ️ No valid synonyms extracted for '${selectedWord}'.`);
        return;
      }

      // Combine synonyms into a single comma-separated string
      const strictSynonym = synonymList.join(",");

      // Force master_id=5072 so it inserts into synonym_de
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
        master_id: 5072 // <-- Ensures synonyms go to German table
      };

      // Insert synonyms into the database
      console.log("Preparing to insert synonyms (DE):", synonymData);

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

function fetchSynonymsFromDictionary(selectedWord) {
  console.log(`🔎 Fetching synonyms from Dictionary.com for: ${selectedWord}`);
  selectedWord = selectedWord.trim().replace(/,$/, "");

  // Build the target Dictionary.com URL
  const targetUrl = `https://www.dictionary.com/browse/${encodeURIComponent(selectedWord)}`;

  // Use our server-side proxy to bypass CORS issues
  const proxyUrl = `proxy_dictionary.php?url=${encodeURIComponent(targetUrl)}`;

  $.ajax({
    url: proxyUrl,
    type: "GET",
    dataType: "html",
    success: function(response) {
      // Parse the HTML using DOMParser
      let parser = new DOMParser();
      let doc = parser.parseFromString(response, "text/html");

      // Example: Find the container that holds the synonyms.
      // This selector may need to be updated based on Dictionary.com's current structure.
      // For example, we might look for a section that contains the <strong>Synonyms:</strong> label.
      let synonymList = [];
      let strongElements = doc.querySelectorAll("strong");
      strongElements.forEach((el) => {
        if (el.textContent.trim().toLowerCase().includes("synonyms:")) {
          // Assume the synonyms are contained in the parent's text
          let containerText = el.parentElement.textContent;
          // Remove the "Synonyms:" label
          let cleanedText = containerText.replace(/synonyms:/i, "").trim();
          // Split the text by commas
          let parts = cleanedText.split(",");
          parts.forEach((part) => {
            let syn = part.trim();
            if (syn && !synonymList.includes(syn)) {
              synonymList.push(syn);
            }
          });
        }
      });

      if (synonymList.length === 0) {
        console.log(`ℹ️ No synonyms found for '${selectedWord}' on Dictionary.com.`);
        return;
      }

      console.log("Dictionary.com synonyms found:", synonymList);

      // Update the table on the front end
      addSynonymsToTable(selectedWord, synonymList);

      // Combine synonyms into a comma-separated string
      const strictSynonym = synonymList.join(",");

      // Build the data object for insertion (forcing master_id 5075 for English)
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
        master_id: 5075
      };

      console.log("Sending data to insert_synonym.php (Dictionary.com):", synonymData);

      // Insert the synonym data into the database
      $.ajax({
        url: "insert_synonym.php",
        type: "POST",
        data: synonymData,
        dataType: "json",
        success: function(response) {
          console.log("Insert Synonym Response (Dictionary.com):", response);
          if (response.success) {
            console.log("✅ Successfully saved Dictionary.com synonyms for:", selectedWord);
          } else {
            console.warn("⚠️ Error saving Dictionary.com synonyms:", response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error (insert_synonym.php - Dictionary.com):", status, error);
          console.error("Response Text:", xhr.responseText);
        }
      });
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error (Dictionary.com fetch via proxy):", status, error);
    }
  });
}

function fetchSynonymsFromThesaurus(selectedWord) {
  console.log(`🔎 Fetching synonyms from Thesaurus.com for: ${selectedWord}`);
  selectedWord = selectedWord.trim().replace(/,$/, "");

  // Build the Thesaurus.com URL for the word
  const targetUrl = `https://www.thesaurus.com/browse/${encodeURIComponent(selectedWord)}`;

  // Use our server-side proxy to bypass CORS issues
  const proxyUrl = `proxy_thesaurus.php?url=${encodeURIComponent(targetUrl)}`;

  $.ajax({
    url: proxyUrl,
    type: "GET",
    dataType: "html",
    success: function(response) {
      // Parse the HTML using DOMParser
      let parser = new DOMParser();
      let doc = parser.parseFromString(response, "text/html");

      // Example: Look for a <p> element with class "wRiDLzD17ooqYbL7AewD" that contains "Strongest matches"
      // and then extract synonyms from anchor tags in the same container.
      let synonymList = [];
      let strongEl = Array.from(doc.querySelectorAll("p.wRiDLzD17ooqYbL7AewD"))
        .find(el => el.textContent.trim().toLowerCase() === "strongest matches");

      if (strongEl) {
        // Assume synonyms are contained in sibling <a> tags; adjust the selector as needed.
        let container = strongEl.parentElement;
        let links = container.querySelectorAll("a");
        links.forEach(link => {
          let text = link.textContent.trim();
          if (text && !synonymList.includes(text)) {
            synonymList.push(text);
          }
        });
      }

      if (synonymList.length === 0) {
        console.log(`ℹ️ No synonyms found for '${selectedWord}' on Thesaurus.com.`);
        return;
      }

      console.log("Thesaurus.com synonyms found:", synonymList);

      // Update the front-end table with these synonyms
      addSynonymsToTable(selectedWord, synonymList);

      // Combine synonyms into a comma-separated string
      const strictSynonym = synonymList.join(",");

      // Build the data object for insertion; force master_id to 5075 (English)
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
        master_id: 5075
      };

      console.log("Sending data to insert_synonym.php (Thesaurus.com):", synonymData);

      // Insert the synonym data into the database
      $.ajax({
        url: "insert_synonym.php",
        type: "POST",
        data: synonymData,
        dataType: "json",
        success: function(response) {
          console.log("Insert Synonym Response (Thesaurus.com):", response);
          if (response.success) {
            console.log("✅ Successfully saved Thesaurus.com synonyms for:", selectedWord);
          } else {
            console.warn("⚠️ Error saving Thesaurus.com synonyms:", response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error (insert_synonym.php - Thesaurus.com):", status, error);
          console.error("Response Text:", xhr.responseText);
        }
      });
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error (Thesaurus.com fetch via proxy):", status, error);
    }
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
  let newRows = newSynonyms
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
  console.log(`🔎 Fetching synonyms from OpenThesaurus.de for: ${selectedWord}`);
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

        // Force synonyms to go to the German table
        master_id: 5072
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

  // Allow closing the modal
$(document).on("click", ".close-modal, #closeComment", function () {
  $("#commentModal").hide();
  $("#notSureCheckbox").prop("checked", false);
});

// Handle double-click to toggle stopword status (works for both English and German)
$(document).on("dblclick", ".synonym-word, .stopword", function (event) {
  event.preventDefault();
  let element = $(this);
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
});

  $(document).on("change", "#synonymTable tbody input[type='checkbox']", function () {
    let row = $(this).closest("tr"); // Find the current row
    row.find("input[type='checkbox']").not(this).prop("checked", false); // Uncheck others
  });
});

$(document).on("submit", "#synonymForm", function (event) {
  event.preventDefault();

  // 1) Retrieve 'selectedWord' from #selected-word
  let selectedWord = $("#selected-word").text().trim();
  if (!selectedWord) {
    alert("Error: Selected word is empty.");
    return;
  }

  // 2) Extract 'mid' from the URL (if needed to decide the correct table)
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid") || 5075; // Default to 5075 (English)

  // 3) Retrieve the root word from multiple possible locations
  let rootWord =
    $("#root-word-container input").val() ||
    $("#root-word-container #root-word-display").text().trim() ||
    $("#root-word").val() ||
    $("#root-word").text().trim();

  // 4) Use Sets to prevent duplicate synonyms in each category (S, Q, O, U)
  let synonyms = {
    S: new Set(),
    Q: new Set(),
    O: new Set(),
    U: new Set(),
  };

  // 5) Loop through each row of the table to find checked synonyms
  $("#synonymTable tbody tr").each(function () {
    let synonymText = $(this).find("td:last").text().trim();

    // For each checkbox in the row, figure out which category (S, Q, O, U)
    $(this)
      .find('input[type="checkbox"]')
      .each(function (index) {
        if ($(this).is(":checked")) {
          const category = ["S", "Q", "O", "U"][index];
          synonyms[category].add(synonymText); // Using Set => duplicates removed
        }
      });
  });

  // 6) Convert each Set into an array of {word: "..."} for JSON
  Object.keys(synonyms).forEach((cat) => {
    synonyms[cat] = Array.from(synonyms[cat]).map((syn) => ({
      word: syn.trim(),
    }));
  });

  // 7) Collect the 'comment' if "Not Sure" checkbox is checked
  let comment = $("#notSureCheckbox").prop("checked")
    ? $("#commentText").val().trim()
    : "";

  // 8) Send the data to the server via AJAX
  $.ajax({
    url: "update_synonym.php",
    type: "POST",
    data: {
      word: selectedWord,
      root_word: rootWord,
      synonyms: JSON.stringify(synonyms),
      comment: comment,
      master_id: mid, // Pass 'master_id' to use the correct table (synonym_de or synonym_en)
    },
    dataType: "json",
    success: function (res) {
      console.log("Update response:", res);
      alert(res.message);

      // Mark the selected word as processed
      $(`.synonym-word[data-word='${selectedWord}']`).addClass("green");

      // Automatically move to the next word (if any)
      clickNextClickableWord();
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error (update_synonym.php):", status, error);
      console.error("Server Response:", xhr.responseText);
      alert("Error updating synonyms. Check console for details.");
    },
  });
});



// When user checks any checkbox in a row, uncheck all others in that row
$(document).on("change", "#synonymTable tbody input[type='checkbox']", function () {
  let row = $(this).closest("tr");
  // Uncheck all other boxes in the same row
  row.find('input[type="checkbox"]').not(this).prop("checked", false);
});



/**
 * Click the next clickable word (blue or green) in the sentence
 */
function clickNextClickableWord() {
  let clickableWords = $(".synonym-word, .synonym-word.green"); // Get all clickable words
  let currentIndex = clickableWords.index($(`.synonym-word[data-word='${selectedWord}']`));

  if (currentIndex !== -1 && currentIndex < clickableWords.length - 1) {
    clickableWords.eq(currentIndex + 1).trigger("click"); // Click the next word
  } else {
    alert("No more clickable words in this symptom. Processing completed.");
  }
}


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
