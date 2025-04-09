var data = null;
var email = null;
var UrlSendOTP = "/admin/register/sendOTP";
var UrlSubmitOTP = "/admin/register";
$("#FormRegisterAdminButton").on("click", function () {
    try {
        // event.preventDefault();
        if (
            $(".is-invalid").length > 0 ||
            $("#yourName").val() === "" ||
            $("#yourEmail").val() === "" ||
            $("#yourPhone").val() === "" ||
            $("#yourPassword").val() === "" ||
            $("#yourConfirmPassword").val() === "" ||
            $("#yourPassword").val() !== $("#yourConfirmPassword").val()
        ) {
            alert("Vui lòng kiểm tra lại thông tin tài khoản");
            return;
        }
        email = $("#yourEmail").val().trim();
        data = {
            _token: $('meta[name="csrf-token"]').attr("content"),
            role: $("select[name='role']").val(),
            name: $("#yourName").val().trim(),
            email: email,
            phone: $("#yourPhone").val().trim(),
            password: $("#yourPassword").val(),
            passwordConfirm: $("#yourConfirmPassword").val(),
        };
        var modal = new bootstrap.Modal(document.getElementById("OTP"));
        $(".loading-overlay").removeClass("d-none");
        $.ajax({
            url: UrlSendOTP,
            type: "POST",
            data: data,
            success: function (response) {
                console.log(response)
                if (response.status === "success") {
                    // hiển thị loading
                    $(".loading-overlay").addClass("d-none");
                    modal.show();
                    console.log(data);
                } else {
                    // hiển thị loading
                    $(".loading-overlay").addClass("d-none");
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                }
            },
            error: function (response) {
                console.log(response);
            },
        });
    } catch (e) {
        console.log(e);
    }
});
$("#submitOTP").on("click", function () {
    try {
        var OTP = $("#yourOTP").val();
        if (OTP == "") {
            alert("Vui lòng nhập mã OTP");
        } else {
            $(".loading-overlay").removeClass("d-none");
            data.OTP = OTP;
            $.ajax({
                url: UrlSubmitOTP,
                type: "POST",
                data: data,
                success: function (response) {
                    console.log(response);
                    $(".loading-overlay").addClass("d-none");
                    if (response.message == "Tạo tài khoản thành công !") {
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else {
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                    }
                },
                error: function (response) {
                    // hiển thị loading
                    $(".loading-overlay").addClass("d-none");
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                },
            });
        }
    } catch (e) {
        console.log(e);
    }
});
$("#yourName").on("change", function () {
    const regex =
        /^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz ]+$/;
    var name = $(this).val();
    var check = regex.test(name);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
});
$("#yourEmail").on("change", function () {
    const regex =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var email = $(this).val();
    var check = regex.test(email);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
});
$("#yourPhone").on("change", function () {
    const regex =
        /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
    var phone = $(this).val();
    var check = regex.test(phone);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
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
