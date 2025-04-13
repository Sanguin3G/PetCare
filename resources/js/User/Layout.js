import { CheckToken } from "./checkToken";
import { TotalItemCart, renderCart } from "./cart/cart";
const token = localStorage.getItem("authTokenPassport_user");
const life_time = localStorage.getItem("authTokenPassport_user_expired_at");
const csfrToken = $('meta[name="csrf-token"]').attr("content");

export const LoadLayout = function () {
    if (CheckToken() == true) {
        $("#dropdown-user").removeClass("d-none");
        $(".buttonLogin").addClass("d-none");
        if (TotalItemCart() > 0) {
            renderCart();
            $(".totalInCart").removeClass("d-none");
            $(".totalInCart").text(TotalItemCart());
        }
    } else {
        $(".buttonLogin").removeClass("d-none");
    }
};
LoadLayout();

$(".button-logout").on("click", function () {
    const urlFetch = "/api/user/account/logout";
    if (token && life_time > new Date().getTime()) {
        try {
            $.ajax({
                url: urlFetch,
                headers: {
                    Authorization: "Bearer " + token,
                },
                data: {
                    _token: csfrToken,
                },
                type: "POST",
                success: function (response) {
                    if (response.message === "Thành công") {
                        localStorage.removeItem("authTokenPassport_user");
                        localStorage.removeItem(
                            "authTokenPassport_user_expired_at"
                        );
                        window.location.reload();
                    } else {
                        alert("Có lỗi xảy ra !");
                    }
                    console.log(response);
                },
                error: function (error) {
                    console.log("Unauthorized");
                },
            });
        } catch (e) {
            console.log(e);
        }
    }
});
$(".button-redirect-order-view").click(function () {
    const urlfetch = "/api/user/order";
    $.ajax({
        url: urlfetch,
        type: "GET",
        headers: {
            Authorization: "Bearer " + token,
        },
        success: function (res) {
            console.log("Response:", res);
            $(".content").empty();
            $(".content").append(res);
            LoadLayout();
            // reattachEventListeners();
        },
    });
});
$(".btn-changepass").on("click", function () {
    var urlFetch = "/api/user/account/changepass/view";
    $.ajax({
        url: urlFetch,
        type: "GET",
        headers: {
            Authorization: "Bearer " + token,
        },
        success: function (response) {
            $(".content").empty();
            $(".content").append(response);
        },
        error: function (error) {
            console.log(response);
        },
    });
});
