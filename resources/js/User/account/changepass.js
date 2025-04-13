const token = localStorage.getItem("authTokenPassport_user");
const life_time = localStorage.getItem("authTokenPassport_user_expired_at");
const csfrToken = $('meta[name="csrf-token"]').attr("content");
$("#formChange").on("submit", function (event) {
    var UrlUpdatePass = "/api/user/account/changepass";
    event.preventDefault();
    var currentPass = $("#currentPassword").val().trim();
    if ($(".is-invalid").length > 0) {
        alert("Please check your information again");
        return;
    }
    $(".loading-overlay").removeClass("d-none");
    $.ajax({
        url: UrlUpdatePass,
        type: "PATCH",
        headers: {
            Authorization: "Bearer " + token,
        },
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            old_password: $("#currentPassword").val().trim(),
            new_password: $("#yourPassword").val().trim(),
        },
        success: function (response) {
            if (response.message == "Update password successfully") {
                $(".loading-overlay").addClass("d-none");
                $("#currentPassword").val("");
                $("#yourPassword").val("");
                $("#yourConfirmPassword").val("");
                $("#currentPassword").removeClass("is-valid");
                $("#yourPassword").removeClass("is-valid");
                $("#yourConfirmPassword").removeClass("is-valid");
                $.toast({
                    heading: "Thông báo",
                    text: response.message,
                    showHideTransition: "slide",
                    icon: response.status,
                    position: "bottom-right",
                });
                return;
            }
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            return;
        },
        error: function (e) {
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: "Có lỗi xảy ra",
                showHideTransition: "slide",
                icon: "error",
                position: "bottom-right",
            });
        },
    });
});
$("#yourPassword").on("change", function () {
    // 8 ký tự  bao gồm chữ , số , chữ hoa
    // const regex = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8})$/;
    const regex = /^.{8,}$/;

    var pass = $(this).val();
    var check = regex.test(pass);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
});
$("#yourConfirmPassword").on("change", function () {
    // const regex = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8})$/;
    const regex = /^.{8,}$/;
    var rePass = $(this).val();
    var check = regex.test(rePass);
    if (check && rePass === $("#yourPassword").val()) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
});
