const token = localStorage.getItem("authTokenPassport_user");
const life_time = localStorage.getItem("authTokenPassport_user_expired_at");
const csfrToken = $('meta[name="csrf-token"]').attr("content");
var email = null;
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
$("#btn-send-OTP").on("click", function (event) {
    event.preventDefault();
    email = $("#yourEmail").val().trim();
    if (!email) {
        alert("please fill your email out");
        return;
    }
    $(".loading-overlay").removeClass("d-none");
    $.ajax({
        url: "/api/auth/user/account/forgetpass/request/sendOTP",
        type: "POST",
        data: {
            _token: csfrToken,
            email: email,
        },
        success: function (response) {
            $(".loading-overlay").addClass("d-none");
            if (response.message === "Success") {
                $.toast({
                    heading: "Thông báo",
                    text: "OTP sent successfully. Check your email and get OTP code",
                    showHideTransition: "slide",
                    icon: "success",
                    position: "bottom-right",
                });
            }
        },
        error: function (error) {
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: "Some wrong has occured. Please try again later",
                showHideTransition: "slide",
                icon: "error",
                position: "bottom-right",
            });
        },
    });
});
$("#Btn-reset-pass").on("click", function () {
    if ($("#yourOTP").val() === "" || $(".is-invalid").length > 0) {
        alert("Vui lòng kiểm tra lại thông tin");
        return;
    }
    $(".loading-overlay").removeClass("d-none");
    $.ajax({
        url: "/api/auth/user/account/forgetpass/request/resetPass",
        type: "POST",
        data: {
            _token: csfrToken,
            email: email,
            OTP: $("#yourOTP").val().trim(),
            password: $("#yourPassword").val().trim(),
        },
        success: function (response) {
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            if (response.message === "Reset password successfully") {
                window.location.reload();
            }
        },
        error: function (error) {
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: "Some wrong has occured. Please try again later",
                showHideTransition: "slide",
                icon: "error",
                position: "bottom-right",
            });
        },
    });
});
