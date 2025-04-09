var UrlFetch = "/api/auth/admin/login";

$(".formLogin").on("submit", function (event) {
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
    $.ajax({
        url: UrlFetch,
        type: "POST",
        data: data,
        success: function (response) {
            console.log("Login response:", response);
            $(".loading-overlay").addClass("d-none");

            if (response.message === "Thành công") {
                $.toast({
                    heading: "Thông báo",
                    text: response.message,
                    showHideTransition: "slide",
                    icon: "success",
                    position: "bottom-right",
                });

                // Lưu token và redirect
                localStorage.setItem("authTokenPassport", response.data);
                $.ajax({
                    url: "/admin/",
                    type: "GET",
                    headers: {
                        Authorization:
                            "Bearer " +
                            localStorage.getItem("authTokenPassport"),
                    },
                    success: function (html) {
                        // console.log("Admin page reloaded successfully");
                        $("body").html(html);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    },
                });
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
});

// Xử lý khi truy cập trực tiếp hoặc refresh /admin/
$(document).ready(function () {
    if (
        window.location.pathname === "/admin/" &&
        localStorage.getItem("authTokenPassport")
    ) {
        $.ajax({
            url: "/admin/",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                console.log("Admin page reloaded successfully");
                $("body").html(html);
            },
            error: function (xhr) {
                console.log("Error reloading admin page:", xhr.responseText);
                if (xhr.status === 401) {
                    window.location.href = "/admin/login";
                }
            },
        });
    }
});
