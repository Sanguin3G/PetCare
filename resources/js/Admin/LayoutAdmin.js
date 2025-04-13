const UrlFetch = "/api/admin/profile";
const token = localStorage.getItem("authTokenPassport");
if (!token) {
    window.location.href = "/admin/login";
} else {
    // $.ajaxSetup({
    //     headers: {
    //         Authorization: "Bearer " + token,
    //     },
    // });
    $("#buttonCreateAccount").hide();
    $("#RedirectSchedule").hide();
    $("#RedirectCustomer").hide();
    $("#RedirectStaff").hide();
    $("#RedirectAccount").hide();
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
                $("#isHasUser").removeClass("d-none");
                $("#NameUser").text(dataUser.name);
                if (dataUser.role == "admin") {
                    $("#buttonCreateAccount").show();
                    $("#RedirectSchedule").show();
                    $("#RedirectCustomer").show();
                    $("#RedirectStaff").show();
                    $("#RedirectAccount").show();
                }
            } else {
                window.location.href = "/admin/";
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
    // chuyển trang
    //home
    $("#RedirectHome").on("click", function () {
        $.ajax({
            url: "/admin/",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectSchedule").on("click", function () {
        $.ajax({
            url: "/admin/ListSchedule",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/ListSchedule";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectCustomer").on("click", function () {
        $.ajax({
            url: "/admin/customer",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/customer";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectStaff").on("click", function () {
        $.ajax({
            url: "/admin/staff",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/staff";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectProduct").on("click", function () {
        $.ajax({
            url: "/admin/product?page=1",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/product";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectCategory").on("click", function () {
        $.ajax({
            url: "/admin/category",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/category";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectService").on("click", function () {
        $.ajax({
            url: "/admin/service",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/service";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectCart").on("click", function () {
        $.ajax({
            url: "/admin/order",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/order";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectDiscount").on("click", function () {
        $.ajax({
            url: "/admin/discount",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/discount";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectVoucher").on("click", function () {
        $.ajax({
            url: "/admin/voucher",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/voucher";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectBooking").on("click", function () {
        $.ajax({
            url: "/admin/book",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/book";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectPost").on("click", function () {
        $.ajax({
            url: "/admin/post",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/post";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    $("#RedirectAccount").on("click", function () {
        $.ajax({
            url: "/admin/customer",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/customer";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    // cài đặt tài khoản
    $("#RedirectProfile").on("click", function () {
        $.ajax({
            url: "/admin/profile",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/profile";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
    // cài đặt tài khoản
    $("#RedirectRegistAccount").on("click", function () {
        $.ajax({
            url: "/admin/register",
            type: "GET",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (html) {
                // console.log("Admin page reloaded successfully");
                window.location.href = "/admin/register";
            },
            error: function (xhr) {
                console.log(xhr);
            },
        });
    });
}
