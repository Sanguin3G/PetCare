var UrlFetch = "/api/auth/user/login";
$(".buttonLogin").on("click", function (event) {
    event.preventDefault();
    var username = $("#yourUsername").val().trim();
    var pass = $("#yourPassword").val().trim();
    if (username === "" || pass === "") {
        alert("Vui lòng nhập đầy đủ thông tin!");
        return;
    }
    $(".loading-overlay").removeClass("d-none");
    var data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        email: username,
        password: pass,
    };
    try {
        $.ajax({
            url: UrlFetch,
            type: "POST",
            data: data,
            success: function (response) {
                $(".loading-overlay").addClass("d-none");
                if (response.message === "Thành công") {
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: "success",
                        position: "bottom-right",
                    });
                    var expirationTime =
                        new Date().getTime() + 15 * 24 * 60 * 60 * 1000; // 15 ngày
                    localStorage.setItem(
                        "authTokenPassport_user",
                        response.data
                    );
                    localStorage.setItem(
                        "authTokenPassport_user_expired_at",
                        expirationTime
                    );
                    localStorage.setItem("Email_User", username);
                    window.location.href = "/";
                } else {
                    $.toast({
                        heading: "Thông báo",
                        text: response.message || "Đăng nhập thất bại",
                        showHideTransition: "slide",
                        icon: "error",
                        position: "bottom-right",
                    });
                }
            },
            error: function (xhr) {
                console.log("Login error:", xhr.responseJSON);
                $(".loading-overlay").addClass("d-none");
                $.toast({
                    heading: "Lỗi",
                    text: xhr.responseJSON?.message || "Có lỗi xảy ra",
                    showHideTransition: "slide",
                    icon: "error",
                    position: "bottom-right",
                });
            },
        });
    } catch (e) {
        console.log(e);
    }
});
