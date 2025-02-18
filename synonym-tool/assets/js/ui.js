$(document).ready(function () {
    $("#toggleView").click(function () {
        $(".left-pane").toggle();
        $(".right-pane").css("width", $(".left-pane").is(":visible") ? "70%" : "100%");
        $(this).text($(".left-pane").is(":visible") ? "⇦" : "⇨");
    });

    $(".symptom-item").click(function () {
        $("#symptom-details").html($(this).html());
    });
});
