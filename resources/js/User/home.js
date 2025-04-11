import { CheckToken } from "./checkToken";
import { Add, TotalItemCart } from "./cart/cart";
if (CheckToken()) {
    $(".buttonBuy").removeClass("d-none");
    $(".buttonBuy").on("click", function () {
        const product = {
            idPro: $(this).data("id"),
            name: $(this).data("name"),
            cost: parseFloat($(this).data("cost")),
            discount: parseFloat($(this).data("discount")),
            image: $(this).data("image"),
            count: 1,
        };
        var result = Add(product);
        if (result) {
            $.toast({
                heading: "Thông báo",
                text: "Thêm sản phẩm vào giỏ hành thành công",
                showHideTransition: "slide",
                icon: "success",
                position: "bottom-right",
            });
            $(".totalInCart").removeClass("d-none");
            $(".totalInCart").text(TotalItemCart());
        } else {
            $.toast({
                heading: "Thông báo",
                text: "Có lỗi xảy ra. Vui lòng thử lại sau",
                showHideTransition: "slide",
                icon: "error",
                position: "bottom-right",
            });
        }
        console.log(TotalItemCart());
    });
} else {
    $(".buttonBuyNoUser").removeClass("d-none");
}
