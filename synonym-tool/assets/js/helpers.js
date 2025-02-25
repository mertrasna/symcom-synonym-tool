
function processSynonymResponse(res, selectedWord) {
    let finalSynonyms = [];

    res.synonyms.forEach((syn) => {
        ["synonym", "cross_reference", "generic_term", "sub_term"].forEach((key, index) => {
            if (syn[key]) {
                syn[key].split(",").forEach((s) => {
                    finalSynonyms.push({ type: ["S", "Q", "O", "U"][index], word: s.trim() });
                });
            }
        });
    });

    fetchRootWord(selectedWord);
}

function displayRootWord(rootRes, selectedWord) {
    let rootWordHTML = rootRes.success && rootRes.word
        ? `<span id="root-word">${rootRes.word}</span>`
        : `<input type="text" id="root-word" value="${selectedWord}" 
            placeholder="Enter root word..." style="padding: 5px; border: 1px solid #ccc; border-radius: 5px; width: 200px;">`;

    $("#symptom-details2").html(`
        <div>
            <p><b>Selected Word:</b> <span id="selected-word">${selectedWord}</span></p>
            <p><b>Root Word:</b> ${rootWordHTML}</p>
        </div>
    `);
}
