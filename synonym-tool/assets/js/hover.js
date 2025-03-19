$(document).ready(function () {
    // Inject CSS dynamically for the popup box
    $("head").append(`
        <style>
            #popup-box {
                display: none;
                position: absolute;
                background-color: #ffffff;
                border: 1px solid #007BFF;
                padding: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                max-width: 320px;
                word-wrap: break-word;
                font-family: Arial, sans-serif;
                font-size: 14px;
                color: #333;
                z-index: 9999;
                transition: opacity 0.3s ease, transform 0.2s ease;
            }

            #popup-box strong {
                color: #007BFF;
                font-weight: bold;
            }

            .synonym-word, .stopword {
                cursor: pointer;
                position: relative;
                transition: all 0.2s ease-in-out;
            }

            .synonym-word:hover, .stopword:hover {
                background-color: rgba(0, 123, 255, 0.1);
                border-radius: 5px;
                padding: 2px 5px;
            }
        </style>
    `);

    // Create and append popup element to body
    let $popup = $("<div id='popup-box'></div>").appendTo("body");

    let isLoading = false;
    let hoverTimeout;
    let lastWord = null;

    // ✅ Retrieve master_id from URL parameters
    function getMasterId() {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.has("mid") ? parseInt(urlParams.get("mid")) : 5075; // Default to 5075 if not found
    }

    $(document).on("mouseenter", ".synonym-word, .stopword", function (event) {
        let $this = $(this);
        let word = $this.attr("data-word");

        if (!word || word === lastWord) return;
        lastWord = word;

        clearTimeout(hoverTimeout);

        hoverTimeout = setTimeout(() => {
            if (isLoading) return;
            isLoading = true;

            $popup.html("<em>Loading...</em>").fadeIn(200);

            // ✅ Fetch master_id dynamically
            let masterId = getMasterId();
            console.log("🔍 Fetching synonyms for:", word, "📌 Master ID:", masterId);

            $.ajax({
                url: "fetch_word_info.php",
                type: "POST",
                data: { 
                    word: word,
                    master_id: masterId  // ✅ Ensure master_id is passed correctly
                },
                dataType: "json",
                success: function (response) {
                    console.log("🔄 Server Response:", response);
                    if (response.success && response.synonyms.length > 0) {
                        let popupContent = `<strong>Word:</strong> ${word}<br>`;
                        response.synonyms.forEach(info => {
                            popupContent += `
                                <strong>Synonym:</strong> ${info.synonym || 'N/A'}<br>
                                <strong>Cross Ref:</strong> ${info.cross_reference || 'N/A'}<br>
                                <strong>Generic:</strong> ${info.generic_term || 'N/A'}<br>
                                <strong>Sub-Term:</strong> ${info.sub_term || 'N/A'}<br>
                            `;
                        });
                        $popup.html(popupContent);
                    } else {
                        $popup.html(`<span style="color: red;">No synonyms found.</span>`);
                    }
                },
                error: function () {
                    console.error("❌ Error fetching data.");
                    $popup.html("<span style='color: red;'>Error fetching data.</span>");
                },
                complete: function () {
                    isLoading = false;
                }
            });

            positionPopup($this);
        }, 250);
    });

    $(document).on("mouseleave", ".synonym-word, .stopword", function () {
        clearTimeout(hoverTimeout);
        $popup.fadeOut(200);
        lastWord = null;
    });

    function positionPopup($element) {
        let offset = $element.offset();
        let top = offset.top + $element.outerHeight() + 8;
        let left = offset.left;
        let popupWidth = $popup.outerWidth();
        let popupHeight = $popup.outerHeight();
        let windowWidth = $(window).width();
        let windowHeight = $(window).height();

        if (left + popupWidth > windowWidth) {
            left = windowWidth - popupWidth - 10;
        }
        if (top + popupHeight > windowHeight) {
            top = offset.top - popupHeight - 8;
        }

        $popup.css({
            top: top,
            left: left,
            opacity: 1,
            transform: "scale(1)"
        }).fadeIn(200);
    }
});
