document.addEventListener("DOMContentLoaded", function () {
  console.log("Worksheet.js loaded!"); // Debugging to ensure the script loads

  // function to fetch synonyms for a symptom
  document.querySelectorAll(".symptom-item").forEach((item) => {
    item.addEventListener("click", function () {
      let symptomText = this.getAttribute("data-original-symptom").trim();
      document.getElementById("selected-symptom").innerText = symptomText;
      document.getElementById("selected-word").innerText =
        "Click a word to select it."; // Reset selected word
      document.getElementById("synonym-list").innerHTML =
        "<li>Select a word from the left to see synonyms.</li>";
    });
  });

  // function to colorize text based on word status
  function colorizeText() {
    document.querySelectorAll(".synonym-word").forEach((item) => {
      let word = item.innerText.trim();

      fetch("../../controllers/WorksheetController.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=checkWordStatus&word=${encodeURIComponent(word)}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "stopword") {
            item.classList.add("gray");
          } else if (data.status === "synonym") {
            item.classList.add("green");
          } else {
            item.classList.add("blue");
          }
        })
        .catch((error) => console.error("Error checking word status:", error));
    });
  }

  // colorize text on page load
  colorizeText();

  // fetch synonyms for a word when clicked
  document.querySelectorAll(".synonym-word").forEach((item) => {
    item.addEventListener("click", function () {
      let word = this.innerText.trim();
      document.getElementById("selected-word").innerText = word;

      fetch("../../controllers/WorksheetController.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `action=searchSynonyms&word=${encodeURIComponent(word)}`,
      })
        .then((response) => response.json())
        .then((data) => {
          let synonymList = document.getElementById("synonym-list");
          synonymList.innerHTML = "";
          if (data.success) {
            data.synonyms.forEach((syn) => {
              let li = document.createElement("li");
              li.innerText = syn.synonym;
              synonymList.appendChild(li);
            });
          } else {
            synonymList.innerHTML = "<li>No synonyms found.</li>";
          }
        })
        .catch((error) => console.error("Error fetching synonyms:", error));
    });
  });

  const toggleButton = document.getElementById("toggleView");
  const leftPane = document.querySelector(".left-pane");
  const rightPane = document.querySelector(".right-pane");

  if (toggleButton) {
    toggleButton.addEventListener("click", function () {
      if (leftPane.style.display === "none" || leftPane.style.width === "0px") {
        leftPane.style.display = "block";
        leftPane.style.width = "30%";
        rightPane.style.width = "70%";
        this.innerText = "⇦"; // Update button text
      } else {
        leftPane.style.display = "none";
        leftPane.style.width = "0px";
        rightPane.style.width = "100%";
        this.innerText = "⇨"; // Update button text
      }
    });
  }
});
