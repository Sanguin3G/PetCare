const UrlUpdatePass = "/admin/changePass";
const UrlUpdateInfor = "/admin/updateProfile";
const UrlFetch = "/api/admin/profile";
const token = localStorage.getItem("authTokenPassport");
var dataUser = null;
$.ajax({
    url: UrlFetch,
    type: "GET",
    headers: {
        Authorization: "Bearer " + token,
    },
    success: function (response) {
        if (response.message == "Thành công") {
            dataUser = response.data;
            $("#UserName").text(dataUser.name);
            $("#name").val(dataUser.name);
            $("#email").val(dataUser.email);
        } else {
            window.location.href = "/admin/";
        }
    },
    error: function (error) {
        console.log(error);
    },
});
$("#RedirectHomeInProfile").on("click", function () {
    $.ajax({
        url: "/admin/",
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
        success: function (html) {
            // console.log("Admin page reloaded successfully");
            $("body").html(html);
        },
        error: function (xhr) {
            console.log(xhr);
        },
    });
});
$("#FormUpdatePassWordAdmin").on("submit", function (event) {
    event.preventDefault();
    try {
        if (
            $(".is-invalid").length > 0 ||
            $("#newPassword_update").val() == "" ||
            $("#renewPassword_update").val() == "" ||
            $("#currentPassword_update").val() == ""
        ) {
            alert("Vui lòng kiểm tra lại mật khẩu");
            return;
        } else {
            $(".loading-overlay").removeClass("d-none");
            $.ajax({
                url: UrlUpdatePass,
                type: "POST",
                headers: {
                    Authorization: "Bearer " + token,
                },
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    old_password: $("#currentPassword_update").val().trim(),
                    new_password: $("#newPassword_update").val().trim(),
                },
                success: function (response) {
                    console.log(response);
                    if (response.message == "Đổi mật khẩu thành công !") {
                        $(".loading-overlay").addClass("d-none");
                        $("#newPassword_update").val("");
                        $("#renewPassword_update").val("");
                        $("#currentPassword_update").val("");
                        $("#newPassword_update").removeClass("is-valid");
                        $("#renewPassword_update").removeClass("is-valid");
                        $("#currentPassword_update").removeClass("is-valid");
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                    } else {
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
        }
    } catch (e) {
        console.log(e);
    }
});
// update infor
$("#FormUpdateInforAdmin").on("submit", function (event) {
    event.preventDefault();
    try {
        if (
            $(".is-invalid").length > 0 ||
            $("#name").val() == "" ||
            $("#email").val() == ""
        ) {
            alert("Vui lòng kiểm tra lại thông tin");
            return;
        } else {
            $(".loading-overlay").removeClass("d-none");
            $.ajax({
                url: UrlUpdateInfor,
                type: "POST",
                headers: {
                    Authorization: "Bearer " + token,
                },
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    name: $("#name").val().trim(),
                    email: $("#email").val().trim(),
                },
                success: function (response) {
                    $(".loading-overlay").addClass("d-none");
                    $("#name").removeClass("is-valid");
                    $("#email").removeClass("is-valid");
                    if (response.status == "success") {
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 500);
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
        }
    } catch (e) {
        console.log(e);
    }
});
$("#newPassword_update").on("change", function () {
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
$("#renewPassword_update").on("change", function () {
    // const regex = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8})$/;
    const regex = /^.{8,}$/;
    var rePass = $(this).val();
    var check = regex.test(rePass);
    if (check && rePass === $("#newPassword_update").val()) {
        $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
    }
});
$("#name").on("change", function () {
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
$("#email").on("change", function () {
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
