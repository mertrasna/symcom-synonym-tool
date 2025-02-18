$(document).on("change", "#notSureCheckbox", function() {
    if(this.checked){
        $("#commentModal").show();
    } else {
        // If unchecked, you can clear the textarea if needed
        $("#commentText").val('');
    }
});

$(document).on("click", ".close-modal", function() {
    $("#commentModal").hide();
    $("#notSureCheckbox").prop("checked", false);
});

// Optionally, close modal when clicking outside the modal-content
$(document).on("click", function(event) {
    if ($(event.target).is("#commentModal")) {
        $("#commentModal").hide();
        $("#notSureCheckbox").prop("checked", false);
    }
});

$(document).on("click", "#saveComment", function() {
    // You can add any saving logic here if needed
    $("#commentModal").hide();
});