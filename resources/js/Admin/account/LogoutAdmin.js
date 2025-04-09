const UrlFetch = "/api/admin/logout";
const token = localStorage.getItem("authTokenPassport");

$("#buttonLogoutAdmin").on("click", function () {
    console.log(token);
    $.ajax({
        url: UrlFetch,
        type: "POST",
        headers: {
            Authorization: "Bearer " + token,
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            if (
                response.status == "success" &&
                response.message == "Đăng xuất thành công"
            ) {
                document.cookie =
                    "petcare_session=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                localStorage.removeItem("authTokenPassport");
                window.location.href = "/admin/login";
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
});
