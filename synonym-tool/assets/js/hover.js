$(document).ready(function () {
    // Injecting CSS dynamically for the popup box
    $("head").append(`
        <style>
            #popup-box {
                display: none;
                position: absolute;
                background-color: #fff;
                border: 2px solid #007BFF; /* Blue border */
                padding: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Soft shadow */
                border-radius: 10px; /* Rounded corners */
                max-width: 300px; /* Set max width */
                word-wrap: break-word; /* Prevent text overflow */
                font-family: Arial, sans-serif; /* Clean font */
                font-size: 14px; /* Adjust font size */
                color: #333; /* Dark text color for better readability */
            }

            #popup-box strong {
                color: #007BFF; /* Blue color for labels */
            }
        </style>
    `);

    // Create and append a popup element to the body
    let $popup = $("<div id='popup-box' style='display:none; position:absolute;'></div>");
    $("body").append($popup);

    let isLoading = false; // Prevent multiple AJAX requests
    let hoverTimeout; // Timeout for debounce
    let lastWord = null; // Avoid redundant requests for the same word

    $(document).on("mouseenter", ".synonym-word, .stopword", function (event) {
        let $this = $(this);
        let word = $this.attr("data-word");

        if (!word || word === lastWord) return; // Skip if no word or same word already requested
        lastWord = word; // Update last requested word

        console.log("Hovered Word:", word);
        
        clearTimeout(hoverTimeout); // Clear any previous timeout to prevent excessive AJAX calls

        hoverTimeout = setTimeout(() => {
            if (isLoading) return; // Prevent multiple AJAX calls
            isLoading = true;

            $popup.text("Loading...").fadeIn(200);

            $.ajax({
                url: "fetch_word_info.php",
                type: "POST",
                data: { word: word },
                dataType: "json",
                success: function (response) {
                    if (response.success && response.synonyms.length > 0) {
                        let popupContent = "<strong>Synonyms:</strong><br><br>";

                        response.synonyms.forEach(info => {
                            popupContent += `
                                <strong>Word:</strong> ${info.word || 'N/A'}<br>
                                <strong>Root Word:</strong> ${info.root_word || 'N/A'}<br>
                                <strong>Synonym:</strong> ${info.synonym || 'N/A'}<br>
                                <strong>Cross Reference:</strong> ${info.cross_reference || 'N/A'}<br>
                                <strong>Partial Synonym 2:</strong> ${info.synonym_partial_2 || 'N/A'}<br>
                                <strong>General Synonym:</strong> ${info.generic_term || 'N/A'}<br>
                                <strong>Sub-Term:</strong> ${info.sub_term || 'N/A'}<br>
                                <strong>Synonym NN:</strong> ${info.synonym_nn || 'N/A'}<br>
                                <strong>Comment:</strong> ${info.comment || 'N/A'}<br>
                                <strong>Status:</strong> ${info.non_secure_flag == 1 ? 'Active' : 'Inactive'}<br>
                                <strong>Is Green:</strong> ${info.isgreen == 1 ? 'Yes' : 'No'}<br>
                                <strong>Created At:</strong> ${info.created_at || 'N/A'}<br><br>
                            `;
                        });

                        $popup.html(popupContent);
                    } else {
                        $popup.html(`<span style="color: red;">No synonyms found.</span>`);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    $popup.html("<span style='color: red;'>Error fetching data.</span>");
                },
                complete: function () {
                    isLoading = false;
                }
            });

            // Position the popup
            positionPopup($this);
        }, 200); // Debounce for 200ms to prevent rapid AJAX calls
    });

    $(document).on("mouseleave", ".synonym-word, .stopword", function () {
        clearTimeout(hoverTimeout); // Clear pending requests when the mouse leaves
        $popup.fadeOut(200);
        lastWord = null; // Reset last word
    });

    function positionPopup($element) {
        let offset = $element.offset();
        let top = offset.top + $element.outerHeight() + 5;
        let left = offset.left;
        let popupWidth = $popup.outerWidth();
        let popupHeight = $popup.outerHeight();
        let windowWidth = $(window).width();
        let windowHeight = $(window).height();

        if (left + popupWidth > windowWidth) {
            left = windowWidth - popupWidth - 10;
        }
        if (top + popupHeight > windowHeight) {
            top = offset.top - popupHeight - 5;
        }

        $popup.css({ top: top, left: left }).fadeIn(200);
    }
});
