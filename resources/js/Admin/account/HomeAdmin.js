const UrlFetch = "/api/admin/profile";
const token = localStorage.getItem("authTokenPassport");
$(document).on("ready", function () {
    $.ajaxSetup({
        headers: {
            Authorization: "Bearer " + token,
        },
    });
    $("#buttonLogin").hide();
    $("#isHasUser").hide();
    $.ajax({
        url: UrlFetch,
        type: "GET",
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        },
    });
});
