$(document).ready(function () {
  let greenWords = new Set();

  $(".symptom-item").click(function () {
    $("#symptom-details").html($(this).html());
  });

  let selectedWord = "";

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

    // Fetch synonyms from OpenAI
    fetchChatGPTSynonyms(selectedWord);
    fetchKorrekturenSynonyms(selectedWord);

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
            [
              "strict_synonym",
              "synonym_partial_1",
              "synonym_general",
              "synonym_minor",
            ].forEach((key, index) => {
              if (syn[key]) {
                syn[key].split(",").forEach((s) => {
                  finalSynonyms.push({
                    type: ["S", "Q", "O", "U"][index],
                    word: s.trim(),
                  });
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

              let rootWordHTML =
                rootRes.success && rootRes.word
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
    const apiKey = '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';
    const requestBody = {
      model: 'gpt-4',
      messages: [
        { role: 'system', content: 'You are a helpful assistant.' },
        { role: 'user', content: `Give me ONLY a list of 5 german synonyms for the word "${selectedWord}"` }
      ],
      max_tokens: 50,
      temperature: 0.7
    };

    fetch('https://api.openai.com/v1/chat/completions', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${apiKey}`,
      },
      body: JSON.stringify(requestBody),
    })
    .then(response => response.json())
    .then(data => {
      console.log("OpenAI Response:", data);

      const chatGptResponse = data.choices[0].message.content.trim();
      const synonyms = chatGptResponse.split(',').map(syn => syn.trim());

      const strictSynonym = synonyms.join(',');

      const synonymData = {
        word: selectedWord,
        strict_synonym: strictSynonym,
        synonym_partial_1: "",
        synonym_partial_2: "",
        synonym_general: "",
        synonym_minor: "",
        synonym_nn: "",
        synonym_comment: "",
        synonym_ns: "1",
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
        }
      });
    })
    .catch(error => {
      console.error("OpenAI API Error:", error);
    });
  }

  // Handle form submission
  $(document).on("submit", "#synonymForm", function (event) {
    event.preventDefault();
    let selectedWord = $("#selected-word").text().trim();
    if (!selectedWord) {
      alert("Error: Selected word is empty.");
      return;
    }

    let synonyms = { S: [], Q: [], O: [], U: [] };
    $("#synonymTable tbody tr").each(function () {
      let synonymText = $(this).find("td:last").text().trim();
      ["S", "Q", "O", "U"].forEach((type, index) => {
        if ($(this).find(`td:eq(${index}) input`).is(":checked")) {
          synonyms[type].push({ word: synonymText });
        }
      });
    });

    let rootWord = $("#root-word").val() || $("#root-word").text().trim();
    let comment = $("#notSureCheckbox").prop("checked")
      ? $("#commentText").val().trim()
      : "";

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
        alert(res.message);
        $(`.synonym-word[data-word='${selectedWord}']`).addClass("green");
        clickNextClickableWord();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error (update_synonym.php):", status, error);
      },
    });
  });

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
});

/**
 * Fallback parser to extract synonyms from raw text
 * after the phrase: "Passendere Begriffe oder andere Wörter für »[word]«"
 */
function parseSynonymsFromText(rawText, selectedWord) {
    console.log("🔎 Fallback text parsing...");

    // If the text says "Keine Synonyme gefunden.", skip entirely
    if (rawText.includes("Keine Synonyme gefunden.")) {
        console.warn("⚠️ Korrekturen says: Keine Synonyme gefunden. Skipping.");
        return [];
    }

    let searchString = `Passendere Begriffe oder andere Wörter für »${selectedWord}«`;
    let startIndex = rawText.indexOf(searchString);
    if (startIndex === -1) {
        console.warn("⚠️ Fallback parser: Could not find the key sentence in raw text.");
        return [];
    }

    // Get a chunk of text (e.g., next 1500 chars) after that heading
    let textChunk = rawText.substring(startIndex, startIndex + 1500);
    console.log("📜 Fallback Text Chunk (first 500 chars):", textChunk.substring(0, 500));

    // Remove the heading line itself by splitting on newline
    let lines = textChunk.split("\n");
    lines.shift(); // remove the heading line
    textChunk = lines.join(" ");

    // Clean parentheses, brackets, bullets, commas, etc.
    let cleaned = textChunk
        .replace(/\(.*?\)/g, "")   // remove (ugs.), etc.
        .replace(/\[.*?\]/g, "")   // remove [☯...], etc.
        .replace(/[•.,]/g, "")     // remove bullets, commas
        .replace(/\s+/g, " ")      // collapse extra spaces
        .trim();

    // Synonyms are often separated by " · " (adjust if needed)
    let synonyms = cleaned.split(" · ")
        .map(s => s.trim())
        .filter(s => s.length > 1);

    console.log("🔎 Fallback synonyms after splitting on ' · ':", synonyms);

    // Limit to 7 synonyms max
    if (synonyms.length > 7) {
        synonyms = synonyms.slice(0, 7);
        console.log("ℹ️ Limiting to 7 synonyms:", synonyms);
    }

    return synonyms;
}


/**
 * Main function that fetches synonyms via PHP + fallback
 * If fewer than 1 synonyms found, or "Keine Synonyme gefunden." is present,
 * we skip entirely.
 */
function fetchKorrekturenSynonyms(selectedWord) {
    console.log(`🔎 Fetching synonyms from Korrekturen.de (server-side) for: ${selectedWord}`);

    $.ajax({
        url: "scrape_korrekturen.php",   // <-- This calls the PHP file
        type: "GET",
        data: { word: selectedWord },
        dataType: "json",
        success: function(response) {
            if (!response.success) {
                console.warn("❌ PHP Proxy Error:", response.message);
                return;
            }

            let html = response.html;
            console.log("✅ Successfully fetched HTML via PHP script.");
            console.log("📜 HTML Preview:", html.substring(0, 1000)); // log first 1000 chars

            // If the HTML itself says "Keine Synonyme gefunden", skip
            if (html.includes("Keine Synonyme gefunden.")) {
                console.warn("⚠️ HTML indicates: Keine Synonyme gefunden. Skipping.");
                return;
            }

            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");

            // 1) Try <a class="synonyme">
            let synonymElements = doc.querySelectorAll("a.synonyme");
            console.log("🔍 Selector: a.synonyme → Found:", synonymElements.length);

            if (!synonymElements.length) {
                console.warn("⚠️ No <a class='synonyme'>. Trying fallback parse...");
                let rawText = doc.body.innerText;
                let fallbackSynonyms = parseSynonymsFromText(rawText, selectedWord);

                if (!fallbackSynonyms.length) {
                    console.warn("⚠️ Fallback parse also found no synonyms. Skipping.");
                    return;
                }

                // Limit to 7 synonyms
                if (fallbackSynonyms.length > 7) {
                    fallbackSynonyms = fallbackSynonyms.slice(0, 7);
                    console.log("ℹ️ Limiting fallback synonyms to 7:", fallbackSynonyms);
                }

                removeDuplicateSynonyms(fallbackSynonyms);
                return;
            }

            // 2) Normal extraction from <a.synonyme>
            let synonymList = [];
            synonymElements.forEach(el => {
                let synonym = el.innerText
                    .replace(/\(.*?\)/g, "")  // Remove (ugs.), etc.
                    .replace(/\[.*?\]/g, "")  // Remove [☯ Gegensatz...]
                    .replace(/[•.,]/g, "")    // Remove bullets, commas, etc.
                    .replace(/\s+/g, " ")     // Collapse extra spaces
                    .trim();

                if (synonym.length > 1 && !synonymList.includes(synonym)) {
                    synonymList.push(synonym);
                }
            });

            console.log("📝 Final Synonyms List (via <a.synonyme>):", synonymList);

            // If empty, fallback parse
            if (!synonymList.length) {
                console.warn("⚠️ No synonyms found after cleaning <a.synonyme>. Trying fallback parse...");
                let fallbackSynonyms = parseSynonymsFromText(doc.body.innerText, selectedWord);

                if (!fallbackSynonyms.length) {
                    console.warn("⚠️ Still no synonyms. Skipping.");
                    return;
                }

                // Limit to 7
                if (fallbackSynonyms.length > 7) {
                    fallbackSynonyms = fallbackSynonyms.slice(0, 7);
                    console.log("ℹ️ Limiting fallback synonyms to 7:", fallbackSynonyms);
                }

                removeDuplicateSynonyms(fallbackSynonyms);
                return;
            }

            // 3) We have synonyms. Limit to 7 if more.
            if (synonymList.length > 7) {
                synonymList = synonymList.slice(0, 7);
                console.log("ℹ️ Limiting synonyms to 7:", synonymList);
            }

            // 4) Add them to your table (avoiding duplicates)
            removeDuplicateSynonyms(synonymList);
        },
        error: function(xhr, status, error) {
            console.error("❌ AJAX Error scraping Korrekturen:", status, error);
        }
    });
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

    let uniqueSynonyms = korrekturenSynonyms.filter(syn => !existingSynonyms.has(syn.toLowerCase()));
    console.log("Unique Synonyms to Add:", uniqueSynonyms);

    let currentCount = $("#synonymTable tbody tr").length;
    let maxTotal = 10;       // <-- TOTAL synonyms allowed in the table
    let maxPerBatch = 7;     // <-- Only add up to 7 synonyms from this fetch

    if (currentCount >= maxTotal) {
        console.warn("⚠️ The table already has 15 synonyms. Not adding any more.");
        return;
    }

    //  The total space left to reach 15
    let spaceLeft = maxTotal - currentCount;
    console.log(`ℹSynonyms in table: ${currentCount}. Space left for total of 15: ${spaceLeft}.`);
    let finalLimit = Math.min(spaceLeft, maxPerBatch);
    console.log(` We can add at most ${finalLimit} synonyms from this batch.`);
    let synonymsToAdd = uniqueSynonyms.slice(0, finalLimit);
    console.log(" Synonyms to actually add:", synonymsToAdd);

    // 7) If none remain, do nothing
    if (synonymsToAdd.length === 0) {
        console.warn("⚠️ No new synonyms added (all were duplicates or limit reached).");
        return;
    }

    // 8) Build table rows
    let newRows = synonymsToAdd.map(syn => `
        <tr>
            <td><input type="checkbox" name="S" value="${syn}"></td>
            <td><input type="checkbox" name="Q" value="${syn}"></td>
            <td><input type="checkbox" name="O" value="${syn}"></td>
            <td><input type="checkbox" name="U" value="${syn}"></td>
            <td>${syn}</td>
        </tr>
    `).join("");

    console.log("📝 Adding New Rows to Table:", newRows);

    $("#synonymTable tbody").append(newRows);
    console.log("✅ Synonyms added successfully!");
}

