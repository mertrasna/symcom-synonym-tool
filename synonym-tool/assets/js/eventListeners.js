const symptomsPerPage = 200;
let greenWords = new Set();
let selectedWord = "";
let pendingSynonyms = [];

$(document).ready(function () {
  if (typeof nonSecureFlag !== "undefined" && nonSecureFlag == 1) {
    $("#notSureCheckbox").prop("checked", true);
  }

  // Update URL with new offset and reload page
  function updateUrlWithOffset(newOffset) {
    const url = new URL(window.location.href);
    url.searchParams.set("offset", newOffset);
    window.location.href = url.toString(); // Reload with updated offset
  }

  // "Reload New Symptoms" button click 
  $(document).on("click", "#reloadSymptoms", function () {
    let currentOffset =
      parseInt(new URLSearchParams(window.location.search).get("offset")) || 0;
    currentOffset += symptomsPerPage; 
    updateUrlWithOffset(currentOffset); 
  });

  // "Back to Start" button click 
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

  $(document).on("click", ".synonym-word, .stopword", function () {
    var selectedWord = $(this).attr("data-word").trim();
    console.log("Selected Word:", selectedWord);

    if (selectedWord) {
      // Build the dictionary URL (modify the URL as needed)
      var dictionaryURL = `https://www.dictionary.com/browse/${encodeURIComponent(selectedWord)}`;
      
      // Update the dictionary button's href and text
      $("#dictionary-btn").attr("href", dictionaryURL);
      $("#dictionary-btn").text(`🔎 Check dictionary for "${selectedWord}"`);
    }
});

  // Handle clicking on synonym words & stopwords
  // Update korrekturen button when clicking on synonym-word or stopword.
$(document).on("click", ".synonym-word, .stopword", function () {
  var selectedWord = $(this).attr("data-word").trim();
  console.log("Selected Word:", selectedWord);

  if (selectedWord) {
      var korrekturenURL = `https://www.korrekturen.de/synonyme/${encodeURIComponent(selectedWord)}/`;
      $("#korrekturen-btn").attr("href", korrekturenURL);
      $("#korrekturen-btn").text(`🔎 Check korrekturen for "${selectedWord}"`);
  }
});

// Handle clicking on synonym words to fetch synonyms and update the table.
$(document).on("click", ".synonym-word", function () {
  var $clicked = $(this);
  var selectedWord = $clicked.attr("data-word").trim();
  console.log("Selected Word:", selectedWord);

  // Check if already processed (green or yellow)
  var isGreen = $clicked.hasClass("green");
  var isYellow = $clicked.hasClass("yellow-word");

  // Extract master id from URL (default to 5075)
  var urlParams = new URLSearchParams(window.location.search);
  var mid = urlParams.get("mid") || "5075";

  // If not processed, trigger external fetches (including ChatGPT)
  if (!isGreen && !isYellow) {
      if (mid === "5075") {
          // For English: trigger ChatGPT fetch along with dictionary & thesaurus
          chatGPTObservable.fetchSynonyms(selectedWord);
          fetchSynonymsFromDictionary(selectedWord);
          fetchSynonymsFromThesaurus(selectedWord);
      } else if (mid === "5072") {
          // For German: trigger ChatGPT fetch and korrekturen; delayed OpenThesaurus fetch.
          chatGPTObservable.fetchSynonyms(selectedWord);
          fetchKorrekturenSynonyms(selectedWord);
          setTimeout(function () {
              fetchSynonymsFromOpenThesaurus(selectedWord);
          }, 500);
      } else {
          console.warn("Unexpected master_id:", mid);
      }
  }

  // Always check the database after a delay.
  setTimeout(function () {
      $.ajax({
          url: "search_synonym.php",
          type: "POST",
          data: { word: selectedWord, master_id: mid },
          dataType: "json",
          success: function (res) {
              console.log("search_synonym.php Response:", res);
              if (res.success && res.synonyms && res.synonyms.length) {
                  var finalSynonyms = [];
                  res.synonyms.forEach(function (syn) {
                      ["synonym", "cross_reference", "generic_term", "sub_term"].forEach(function (key, index) {
                          if (syn[key]) {
                              syn[key].split(",").forEach(function (s) {
                                  finalSynonyms.push({
                                      type: ["S", "Q", "O", "U"][index],
                                      word: s.trim()
                                  });
                              });
                          }
                      });
                  });

                  // Build the synonym table.
                  var tableHTML = `
        <table id="synonymTable" class="styled-table">
          <thead>
            <tr><th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th></tr>
          </thead>
          <tbody>
      `;
                  finalSynonyms.forEach(function (syn) {
                      tableHTML += `<tr>
          <td><input type="checkbox" name="S" value="${syn.word}" ${syn.type === "S" ? "checked" : ""}></td>
          <td><input type="checkbox" name="Q" value="${syn.word}" ${syn.type === "Q" ? "checked" : ""}></td>
          <td><input type="checkbox" name="O" value="${syn.word}" ${syn.type === "O" ? "checked" : ""}></td>
          <td><input type="checkbox" name="U" value="${syn.word}" ${syn.type === "U" ? "checked" : ""}></td>
          <td>${syn.word}</td>
        </tr>`;
                  });
                  tableHTML += "</tbody></table>";

                  $("#synonymTableContainer").html(tableHTML);
                  if (res.non_secure_flag && res.non_secure_flag == 1) {
                      $("#synonymForm #notSureCheckbox").prop("checked", true);
                  } else {
                      $("#synonymForm #notSureCheckbox").prop("checked", false);
                  }

                  // Only if synonyms exist, fetch the root word and mark as processed.
                  $.ajax({
                      url: "fetch_root_word.php",
                      type: "POST",
                      data: { word: selectedWord, master_id: mid },
                      dataType: "json",
                      success: function (rootRes) {
                          console.log("fetch_root_word.php Response:", rootRes);
                          var rootWordHTML = rootRes.success
                              ? `<input type="text" id="root-word" value="${rootRes.word}" placeholder="Enter root word..." class="input-box">`
                              : `<input type="text" id="root-word" value="${selectedWord}" placeholder="Enter root word..." class="input-box">`;

                          var headerHTML = `
          <div class="synonym-header">
            <p><b>Selected Word:</b> <span id="selected-word">${selectedWord}</span></p>
            <p><b>Root Word:</b> ${rootWordHTML}</p>
          </div>
        `;
                          $("#synonymTableContainer").prepend(headerHTML);

                          // Mark the word properly: keep yellow if already set, else mark as green.
                          if (isYellow) {
                              $clicked.addClass("yellow-word");
                          } else {
                              $clicked.addClass("green");
                          }

                          // Auto-click the processed element if not already done.
                          if (!$clicked.data("autoClicked")) {
                              $clicked.data("autoClicked", true);
                              console.log("Auto-clicking processed element again...");
                              setTimeout(function () {
                                  $clicked.trigger("click");
                              }, 500);
                          }
                      },
                      error: function (xhr, status, error) {
                          console.error("AJAX Error (fetch_root_word.php):", status, error);
                      }
                  });
              } else {
                  $("#synonymTableContainer").html(
                    `<p style="color:red;">No synonyms found for '${selectedWord}'.</p>`
                  );
                  // Do NOT mark the word as processed if no synonyms were found.
              }
          },
          error: function (xhr, status, error) {
              console.error("AJAX Error (search_synonym.php):", status, error);
          },
      });
  }, 700);
});


  // Function to wrap the selected text as a phrase, preserving spaces
  function linkSelectedWords() {
    let selection = window.getSelection();
    if (!selection.rangeCount) return "";

    let range = selection.getRangeAt(0);
    let text = selection.toString().trim();

    // Ensure the selection contains multiple words (i.e. a phrase)
    if (text.split(/\s+/).length < 2) {
      console.warn("Selection must contain multiple words to be a phrase.");
      return "";
    }

    // Normalize spaces (convert multiple spaces to a single space)
    text = text.replace(/\s+/g, " ");

    // Create a span to wrap the whole phrase
    let span = document.createElement("span");
    span.classList.add("synonym-word", "yellow-word"); 
    span.setAttribute("data-word", text); 
    span.textContent = text;

    // Replace the selected content with this span
    range.deleteContents();
    range.insertNode(span);
    selection.removeAllRanges();

    return text;
  }

  // Use Ctrl+K or right-click to call processLinkedWords()
  function processLinkedWords() {
    const linkedText = linkSelectedWords();
    if (linkedText) {
      console.log("Linked phrase:", linkedText);
      fetchSynonymsFromThesaurus(linkedText);
      chatGPTObservable.fetchSynonyms(linkedText);
    } else {
      console.warn("No words selected to link.");
    }
  }

  $(document).keydown(function (event) {
    if ((event.ctrlKey || event.metaKey) && event.key === "k") {
      event.preventDefault();
      processLinkedWords();
    }
  });

  $(document).on("contextmenu", function (event) {
    if ($(event.target).hasClass("synonym-word")) {
      event.preventDefault();
      processLinkedWords();
    }
  });

  //  ChatGPT Observable (Publisher)
  class ChatGPTObservable {
    constructor() {
      this.observers = [];
    }

    subscribe(observer) {
      this.observers.push(observer);
    }

    notify(data) {
      this.observers.forEach((observer) => observer.update(data));
    }

    fetchSynonyms(selectedWord) {
      console.log(`🔎 Fetching synonyms from ChatGPT for: ${selectedWord}`);

      // Determine the language based on masterId (5072 for German, default to English)
      const language = masterId === 5072 ? "German" : "English";

      const apiKey =
        "key"; // Replace with your API key

      const requestBody = {
        model: "gpt-4",
        messages: [
          {
            role: "system",
            content: "You are a helpful assistant providing synonyms.",
          },
          {
            role: "user",
            content: `List exactly 5 ${language} synonyms for the word "${selectedWord}", separated ONLY by commas. Do not include any additional text or explanations.`,
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

          if (!data.choices || !data.choices[0] || !data.choices[0].message) {
            console.error(" Invalid response from OpenAI API:", data);
            return;
          }

          const chatGptResponse = data.choices[0].message.content.trim();
          const synonyms = chatGptResponse
            .split(",")
            .map((syn) => syn.trim())
            .filter(Boolean);

          if (synonyms.length === 0) {
            console.warn(
              ` No valid synonyms found for '${selectedWord}' from ChatGPT.`
            );
            return;
          }


          console.log(" ChatGPT synonyms found:", synonyms);

          // Notify all observers with the fetched synonyms
          this.notify({ word: selectedWord, synonyms, master_id: masterId });
        })
        .catch((error) => {
          console.error("❌ OpenAI API Error:", error);
        });
    }
  }

  //  Synonym Table Observer (Updates UI)
  class SynonymTableObserver {
    update(data) {
      console.log("📝 Updating UI with synonyms:", data);

      if (!data.synonyms || data.synonyms.length === 0) {
        $("#synonymTableContainer").html(
          `<p style="color:red;">No synonyms found for '${data.word}'.</p>`
        );
        return;
      }

      let tableHTML = `
      <table id="synonymTable" class="styled-table">
        <thead>
          <tr><th>S</th><th>Q</th><th>O</th><th>U</th><th>Synonym</th></tr>
        </thead>
        <tbody>
    `;

      data.synonyms.forEach((syn) => {
        tableHTML += `<tr>
        <td><input type="checkbox" name="S" value="${syn}"></td>
        <td><input type="checkbox" name="Q" value="${syn}"></td>
        <td><input type="checkbox" name="O" value="${syn}"></td>
        <td><input type="checkbox" name="U" value="${syn}"></td>
        <td>${syn}</td>
      </tr>`;
      });

      tableHTML += "</tbody></table>";

      $("#synonymTableContainer").html(tableHTML);
      $("#synonymTableContainer input[type='checkbox']").prop("checked", false);
      console.log(" UI updated with new synonyms!");
    }
  }

  class SynonymDatabaseObserver {
    async update(data) {
      console.log("📤 Preparing to save to DB:", data);

      //  Ensure word is valid
      if (!data.word || data.word.trim() === "") {
        console.warn(" Word is missing or empty. Aborting save.");
        return;
      }

      if (!data.synonyms || data.synonyms.length === 0) {
        console.warn(" No synonyms provided. Aborting save.");
        return;
      }

      const synonymData = {
        word: data.word.trim(), // Ensure no leading/trailing spaces
        synonym: data.synonyms.join(","), // Convert array to comma-separated string
        cross_reference: "",
        synonym_partial_2: "",
        generic_term: "",
        sub_term: "",
        synonym_nn: "",
        comment: "",
        non_secure_flag: "0",
        source_reference_ns: "1",
        active: "1",
        master_id: data.master_id,
      };

      console.log("📤 Sending data to insert_synonym.php:", synonymData);

      try {
        const response = await fetch("insert_synonym.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" }, // Fix: Change from JSON to form data
          body: new URLSearchParams(synonymData).toString(),
        });

        const result = await response.json();
        console.log(" Server Response:", result);

        if (!result.success) {
          console.warn(` Database Insert Failed: ${result.message}`);
        }
      } catch (error) {
        console.error("❌ Error saving ChatGPT synonyms:", error);
      }
    }
  }

  //  Initialize Observer Pattern
  const chatGPTObservable = new ChatGPTObservable();
  const synonymTableObserver = new SynonymTableObserver();
  const synonymDatabaseObserver = new SynonymDatabaseObserver();

  // Subscribe Observers
  chatGPTObservable.subscribe(synonymTableObserver);
  chatGPTObservable.subscribe(synonymDatabaseObserver);

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
          non_secure_flag: "0",
          source_reference_ns: "1",
          active: 1,
          master_id: 5072, // <-- Ensures synonyms go to German table
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
    console.log(
      `🔎 Fetching synonyms from Dictionary.com for: ${selectedWord}`
    );
    selectedWord = selectedWord.replace(/[.,!?;:]$/, "").trim();

    function fetchWord(word, originalWord = selectedWord) {
      const targetUrl = `https://www.dictionary.com/browse/${encodeURIComponent(
        word
      )}`;
      const proxyUrl = `proxy_facade.php?type=dictionary&targetUrl=${encodeURIComponent(
        targetUrl
      )}`;

      $.ajax({
        url: proxyUrl,
        type: "GET",
        dataType: "html",
        success: function (response) {
          let parser = new DOMParser();
          let doc = parser.parseFromString(response, "text/html");

          let synonymList = [];
          let strongElements = doc.querySelectorAll("strong");

          strongElements.forEach((el) => {
            if (el.textContent.trim().toLowerCase().includes("synonyms:")) {
              let containerText = el.parentElement.textContent;
              let cleanedText = containerText.replace(/synonyms:/i, "").trim();
              let parts = cleanedText.split(",");
              parts.forEach((part) => {
                let syn = part.trim();
                if (syn && !synonymList.includes(syn)) {
                  synonymList.push(syn);
                }
              });
            }
          });

          //  If synonyms are found, save them under the original word
          if (synonymList.length > 0) {
            console.log(" Dictionary.com synonyms found:", synonymList);
            addSynonymsToTable(originalWord, synonymList);

            const synonymData = {
              word: originalWord, //  Always save under the original word
              synonym: synonymList.join(","),
              cross_reference: "",
              synonym_partial_2: "",
              generic_term: "",
              sub_term: "",
              synonym_nn: "",
              comment: "",
              non_secure_flag: "0",
              source_reference_ns: "1",
              active: "1",
              master_id: 5075,
            };

            console.log("📤 Sending data to insert_synonym.php:", synonymData);

            $.ajax({
              url: "insert_synonym.php",
              type: "POST",
              data: synonymData,
              dataType: "json",
              success: function (response) {
                console.log(" Insert Synonym Response:", response);
              },
              error: function (xhr, status, error) {
                console.error(
                  "❌ AJAX Error (insert_synonym.php - Dictionary.com):",
                  status,
                  error
                );
                console.error("Response Text:", xhr.responseText);
              },
            });
          } else {
            // ❌ No synonyms found, try searching with a transformed word
            let transformedWord = transformWord(word);
            if (transformedWord && transformedWord !== word) {
              console.log(
                `🔄 No synonyms for '${word}'. Trying '${transformedWord}'`
              );
              fetchWord(transformedWord, originalWord); //  Keep the original word for saving
            } else {
              console.log(
                `ℹ️ No synonyms found for '${word}' on Dictionary.com.`
              );
            }
          }
        },
        error: function (xhr, status, error) {
          console.error(
            "❌ AJAX Error (Dictionary.com fetch via proxy):",
            status,
            error
          );
        },
      });
    }

    fetchWord(selectedWord);
  }

  //  Word transformation function: Only changes the word for searching, not saving
  function transformWord(word) {
    let transformedWord = null;

    if (word.endsWith("s") && word.toLowerCase() !== "is") {
      transformedWord = word.slice(0, -1); // "runs" → "run"
    } else if (word.endsWith("ing") && word.length > 5) {
      if (word.endsWith("ying")) {
        transformedWord = word.slice(0, -3) + "ie"; // "crying" → "cry"
      } else if (word.endsWith("eing")) {
        transformedWord = word.slice(0, -3); // "seeing" → "see"
      } else if (word.endsWith("ling") && word.length > 6) {
        transformedWord = word.slice(0, -3) + "e"; // "grumbling" → "grumble"
      } else {
        transformedWord = word.slice(0, -3) + "e"; // "choosing" → "choose"
      }
    } else if (word.endsWith("ed") && word.length > 4) {
      if (word.endsWith("ied")) {
        transformedWord = word.slice(0, -3) + "y"; // "studied" → "study"
      } else if (word.endsWith("eed")) {
        transformedWord = word.slice(0, -2); // "freed" → "free"
      } else {
        transformedWord =
          word.slice(0, -2) + (word[word.length - 3] === "e" ? "" : "e");
      }
    } else if (word.endsWith("d") && word.length > 3) {
      transformedWord =
        word.slice(0, -1) + (word[word.length - 2] === "e" ? "" : "e"); // "loaded" → "load"
    } else if (word.endsWith("ness") && word.length > 5) {
      transformedWord = word.slice(0, -4); // "happiness" → "happy"
      if (transformedWord.endsWith("i")) {
        transformedWord = transformedWord.slice(0, -1) + "y";
      }
    }

    return transformedWord;
  }

  function fetchSynonymsFromThesaurus(selectedWord) {
    console.log(`🔎 Fetching synonyms from Thesaurus.com for: ${selectedWord}`);
    selectedWord = selectedWord.replace(/[.,!?;:]$/, "").trim();

    function fetchWord(word, originalWord = selectedWord) {
      const targetUrl = `https://www.thesaurus.com/browse/${encodeURIComponent(
        word
      )}`;
      const proxyUrl = `proxy_facade.php?type=thesaurus&targetUrl=${encodeURIComponent(
        targetUrl
      )}`;

      $.ajax({
        url: proxyUrl,
        type: "GET",
        dataType: "html",
        success: function (response) {
          let parser = new DOMParser();
          let doc = parser.parseFromString(response, "text/html");

          let synonymList = [];
          let strongEl = Array.from(
            doc.querySelectorAll("p.wRiDLzD17ooqYbL7AewD")
          ).find(
            (el) => el.textContent.trim().toLowerCase() === "strongest matches"
          );

          if (strongEl) {
            let container = strongEl.parentElement;
            let links = container.querySelectorAll("a");
            links.forEach((link) => {
              let text = link.textContent.trim();
              if (text && !synonymList.includes(text)) {
                synonymList.push(text);
              }
            });
          }

          //  If synonyms are found, save them under the original word
          if (synonymList.length > 0) {
            console.log(" Thesaurus.com synonyms found:", synonymList);
            addSynonymsToTable(originalWord, synonymList);

            const synonymData = {
              word: originalWord, //  Always save under the original word
              synonym: synonymList.join(","),
              cross_reference: "",
              synonym_partial_2: "",
              generic_term: "",
              sub_term: "",
              synonym_nn: "",
              comment: "",
              non_secure_flag: "0",
              source_reference_ns: "1",
              active: "1",
              master_id: 5075,
            };

            console.log("📤 Sending data to insert_synonym.php:", synonymData);

            $.ajax({
              url: "insert_synonym.php",
              type: "POST",
              data: synonymData,
              dataType: "json",
              success: function (response) {
                console.log(" Insert Synonym Response:", response);
              },
              error: function (xhr, status, error) {
                console.error(
                  "❌ AJAX Error (insert_synonym.php - Thesaurus.com):",
                  status,
                  error
                );
                console.error("Response Text:", xhr.responseText);
              },
            });
          } else {
            // ❌ No synonyms found, try searching with a transformed word
            let transformedWord = transformWord(word);
            if (transformedWord && transformedWord !== word) {
              console.log(
                `🔄 No synonyms for '${word}'. Trying '${transformedWord}'`
              );
              fetchWord(transformedWord, originalWord); //  Keep the original word for saving
            } else {
              console.log(
                `ℹ️ No synonyms found for '${word}' on Thesaurus.com.`
              );
            }
          }
        },
        error: function (xhr, status, error) {
          console.error(
            "❌ AJAX Error (Thesaurus.com fetch via proxy):",
            status,
            error
          );
        },
      });
    }

    fetchWord(selectedWord);
  }

  function addSynonymsToTable(word, synonyms) {
    if (!synonyms || synonyms.length === 0) {
      return;
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
      return; 
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
        " The table already has 15 synonyms. Not adding any more."
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
        " No new synonyms added (all were duplicates or limit reached)."
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
    console.log(" Synonyms added successfully!");
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
          non_secure_flag: "0",
          source_reference_ns: "1",
          active: "1",

          // Force synonyms to go to the German table
          master_id: 5072,
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
                " Successfully saved OpenThesaurus synonyms for:",
                selectedWord
              );
            } else {
              console.warn(" Error saving synonyms:", response.message);
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

  // Handle clicking the New Assignment button
  $(document).on("click", "#newAssignmentBtn", function (event) {
    event.preventDefault();

    // Get the currently selected word
    let selectedWord = $("#selected-word").text();
    console.log("Before trim - Selected Word:", selectedWord);

    if (!selectedWord || typeof selectedWord === "undefined") {
      console.error("❌ Error: Selected word is undefined!");
      alert("Error: No word is currently selected.");
      return;
    }
    selectedWord = selectedWord.trim();

    console.log("New Assignment button clicked for word:", selectedWord);

    // Clear the existing synonym table
    $("#synonymTable tbody").empty();

    // Reset not-sure checkbox and comment
    $("#notSureCheckbox").prop("checked", false);
    $("#commentText").val("");

    // Get the current root word value
    let rootWord = $("#root-word").val();
    console.log("Before trim - Root Word:", rootWord);

    if (!rootWord || typeof rootWord === "undefined") {
      console.warn(
        " Warning: Root word is undefined. Setting default value."
      );
      rootWord = "";
    }
    rootWord = rootWord.trim();

    // Get the symptom text from the symptom details container
    let symptomText = $("#symptom-details").text();
    console.log("Before trim - Symptom Text:", symptomText);

    if (!symptomText || typeof symptomText === "undefined") {
      console.warn(
        " Warning: Symptom Text is undefined. Setting default value."
      );
      symptomText = "N/A";
    }
    symptomText = symptomText.trim();

    // Extract master ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const mid = urlParams.get("mid") || "5075";

    console.log("Submitting new assignment with:", {
      word: selectedWord,
      root_word: rootWord,
      symptom_text: symptomText,
      master_id: mid,
    });

    // Start a fresh synonym search based on language
    if (mid === "5072") {
      console.log("Starting fresh German synonym search for:", selectedWord);
      if (typeof fetchChatGPTSynonyms === "function")
        fetchChatGPTSynonyms(selectedWord);
      if (typeof fetchKorrekturenSynonyms === "function")
        fetchKorrekturenSynonyms(selectedWord);
      setTimeout(function () {
        if (typeof fetchSynonymsFromOpenThesaurus === "function")
          fetchSynonymsFromOpenThesaurus(selectedWord);
      }, 500);
    } else {
      console.log("Starting fresh English synonym search for:", selectedWord);
      if (typeof fetchSynonymsFromDictionary === "function")
        fetchSynonymsFromDictionary(selectedWord);
      if (typeof fetchSynonymsFromThesaurus === "function")
        fetchSynonymsFromThesaurus(selectedWord);
    }

    //  Pass symptomText in the AJAX request
    $.ajax({
      url: "update_synonym.php",
      type: "POST",
      data: {
        word: selectedWord,
        root_word: rootWord,
        symptom_text: symptomText,
        master_id: mid,
      },
      dataType: "json",
      success: function (res) {
        console.log(" New assignment response:", res);
        alert(res.message || "New assignment created successfully.");
      },
      error: function (xhr, status, error) {
        console.error("❌ AJAX Error (update_synonym.php):", status, error);
        alert("Error creating a new assignment. Check console for details.");
      },
    });

    alert("Creating a new assignment for the word: " + selectedWord);
  });

  //  Close modal and keep checkbox checked
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

  $(document).on(
    "change",
    "#synonymTable tbody input[type='checkbox']",
    function () {
      let row = $(this).closest("tr"); // Find the current row
      row.find("input[type='checkbox']").not(this).prop("checked", false); // Uncheck others
    }
  );
});

$(document).on("submit", "#synonymForm", function (event) {
  event.preventDefault();

  // 1) Retrieve 'selectedWord' from #selected-word
  let selectedWord = $("#selected-word").text();
  if (!selectedWord) {
    alert("Error: Selected word is empty.");
    return;
  }

  // Remove any trailing commas that might cause issues
  selectedWord = selectedWord.replace(/,+$/, "");

  // 2) Extract 'mid' from the URL (if needed to decide the correct table)
  const urlParams = new URLSearchParams(window.location.search);
  const mid = urlParams.get("mid") || 5075; // Default to 5075 (English)

  // 3) Retrieve the root word from multiple possible locations
  let rootWord =
    $("#root-word-container input").val() ||
    $("#root-word-container #root-word-display").text() ||
    $("#root-word").val() ||
    $("#root-word").text();

  // Remove any trailing commas from root word
  rootWord = rootWord.replace(/,+$/, "");

  // 4) Use Sets to prevent duplicate synonyms in each category (S, Q, O, U)
  let synonyms = {
    S: new Set(),
    Q: new Set(),
    O: new Set(),
    U: new Set(),
  };

  // 5) Loop through each row of the table to find checked synonyms
  $("#synonymTable tbody tr").each(function () {
    let synonymText = $(this).find("td:last").text();

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
      word: syn,
    }));
  });

  // 7) Collect the 'comment' if "Not Sure" checkbox is checked
  let comment = $("#notSureCheckbox").prop("checked")
    ? $("#commentText").val()
    : "";

  //  Capture manually entered synonym
  let manualSynonymText = $("#manualSynonym").val();
  let manualSynonymType = [];

  //  Capture selected checkbox types for manual synonym
  ["S", "Q", "O", "U"].forEach((type, index) => {
    if ($(`#manual${type}`).is(":checked")) {
      manualSynonymType.push(type);
    }
  });

  //  If a manual synonym is entered, add it to the respective categories
  manualSynonymType.forEach((type) => {
    synonyms[type].push({ word: manualSynonymText });
  });

  //  Retrieve the symptom text from the worksheet
  let symptomText = $("#symptom-details").text() || ""; // Handle it the same way as other fields

  //  Debugging: Log all data before submission
  console.log("🔍 Submitting Synonym Data:", {
    word: selectedWord,
    root_word: rootWord,
    synonyms: synonyms,
    manual_synonym: manualSynonymText,
    manual_synonym_types: manualSynonymType,
    comment: comment,
    symptom_text: symptomText, //  Included symptom text
    master_id: mid,
  });

  // 8) Send the data to the server via AJAX
  $.ajax({
    url: "update_synonym.php",
    type: "POST",
    data: {
      word: selectedWord,
      root_word: rootWord,
      synonyms: JSON.stringify(synonyms),
      manual_synonym: manualSynonymText,
      manual_synonym_types: JSON.stringify(manualSynonymType),
      comment: comment,
      symptom_text: symptomText, //  Included symptom text
      master_id: mid, // Pass 'master_id' to use the correct table (synonym_de or synonym_en)
    },
    dataType: "json",
    success: function (res) {
      console.log(" Update Response:", res);
      alert(res.message);

      // If the selected word contains a space, mark it with yellow-word (phrase); else mark it as green.
      if (selectedWord.indexOf(" ") !== -1) {
        $(`.synonym-word[data-word='${selectedWord}']`).addClass("yellow-word");
      } else {
        $(`.synonym-word[data-word='${selectedWord}']`).addClass("green");
      }

      // Automatically move to the next word (if any)
      clickNextClickableWord();
    },
    error: function (xhr, status, error) {
      console.error("❌ AJAX Error (update_synonym.php):", status, error);
      console.error("Server Response:", xhr.responseText);
      alert("Error updating synonyms. Check console for details.");
    },
  });
});

// When user checks any checkbox in a row, uncheck all others in that row
$(document).on(
  "change",
  "#synonymTable tbody input[type='checkbox']",
  function () {
    let row = $(this).closest("tr");
    // Uncheck all other boxes in the same row
    row.find('input[type="checkbox"]').not(this).prop("checked", false);
  }
);

$(document).on("click", "#toggleAllSBtn", function () {
  console.log("🔄 Toggling all 'S' checkboxes.");

  let checkboxes = $("#synonymTable tbody input[type='checkbox'][name='S']");
  let allChecked =
    checkboxes.length > 0 &&
    checkboxes.filter(":checked").length === checkboxes.length;

  if (allChecked) {
    checkboxes.prop("checked", false); // Uncheck all
    console.log(" All 'S' checkboxes unchecked.");
  } else {
    checkboxes.prop("checked", true); // Check all
    console.log(" All 'S' checkboxes checked.");
  }
});

/**
 * Click the next clickable word (blue or green) in the sentence
 */
function clickNextClickableWord() {
  let clickableWords = $(
    ".synonym-word, .synonym-word.green , .synonym-word.yellow-word"
  ); // Get all clickable words
  let currentIndex = clickableWords.index(
    $(`.synonym-word[data-word='${selectedWord}']`)
  );

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
