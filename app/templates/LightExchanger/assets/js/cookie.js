$(document).ready(function() {
    $("#cookieBtn").on("click", function() {
        $.cookie("closedCookie", 1, { expires: 1 });
    });

    var cookieValue = $.cookie("closedCookie");
    if (cookieValue) {
        $("#cookiePopup").remove();
    } else {
        $("#cookiePopup").show();
    }
});