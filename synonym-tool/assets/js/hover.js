$(document).ready(function () {

    // Create a popup element and append it to the body
    let $popup = $("<div id='popup-box' style='display:none; position:absolute; background-color: #fff; border: 1px solid #ccc; padding: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'></div>");
    $("body").append($popup);

    // Show popup on hover
    $(document).on("mouseenter", ".synonym-word, .stopword", function (event) {
        let word = $(this).attr("data-word"); // Get the word being hovered over
        console.log("Hovered Word:", word);

        // Show a loading message while waiting for the response
        $popup.text("Loading...").fadeIn(200);

        // Make an AJAX request to fetch word information from the PHP backend
        $.ajax({
            url: "fetch_word_info.php", // PHP file to fetch data
            type: "POST",
            data: { word: word }, // Send the hovered word to the server
            dataType: "json", // Expect a JSON response
            success: function (response) {
                if (response.success) {
                    // If synonyms were found, display the results
                    let synonyms = response.synonyms;
                    let popupContent = "<strong> </strong><br><br>";

                    synonyms.forEach(function(info) {
                        popupContent += `
                            <strong>Word:</strong> ${info.word || 'N/A'}<br>
                            <strong>Root Word:</strong> ${info.root_word || 'N/A'}<br>
                            <strong>Strict Synonym:</strong> ${info.strict_synonym || 'N/A'}<br>
                            <strong>Partial Synonym 1:</strong> ${info.synonym_partial_1 || 'N/A'}<br>
                            <strong>Partial Synonym 2:</strong> ${info.synonym_partial_2 || 'N/A'}<br>
                            <strong>General Synonym:</strong> ${info.synonym_general || 'N/A'}<br>
                            <strong>Minor Synonym:</strong> ${info.synonym_minor || 'N/A'}<br>
                            <strong>Synonym NN:</strong> ${info.synonym_nn || 'N/A'}<br>
                            <strong>Comment:</strong> ${info.synonym_comment || 'N/A'}<br>
                            <strong>Status:</strong> ${info.synonym_ns == 1 ? 'Active' : 'Inactive'}<br>
                            <strong>isgreen:</strong> ${info.isgreen == 1 ? 'Yes' : 'No'}<br>
                            <strong>Created At:</strong> ${info.created_at || 'N/A'}<br><br>
                        `;
                    });

                    $popup.html(popupContent); // Set the popup content to the fetched data
                } else {
                    // If no synonyms were found, show an error message
                    $popup.html(`<span style="color: red;">${response.message}</span>`);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $popup.html("Error fetching data. Please try again.");
            }
        });

        // Position the popup near the hovered word
        let offset = $(this).offset();
        let top = offset.top + $(this).outerHeight() + 5; // Position it just below the word
        let left = offset.left;

        // Show the popup and position it
        $popup.css({ top: top, left: left }).fadeIn(200);
    });

    // Hide popup when mouse leaves the word
    $(document).on("mouseleave", ".synonym-word, .stopword", function () {
        $popup.fadeOut(200);
    });
});
