import { CheckToken } from "./checkToken";
import { TotalItemCart, renderCart } from "./cart/cart";
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
    const token = localStorage.getItem("authTokenPassport_user");
    const life_time = localStorage.getItem("authTokenPassport_user_expired_at");
    const urlFetch = "/api/user/account/logout";
    const csfrToken = $('meta[name="csrf-token"]').attr("content");
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
