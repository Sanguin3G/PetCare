import { CheckToken } from "./../checkToken";
import { Add, TotalItemCart, getCart } from "./../cart/cart";
const CountProduct = $("#CountProduct").text();
if (CountProduct <= 0) {
    $("#ButtonSoldOut").removeClass("d-none");
}
$(document).ready(function () {
    var listImage = document.querySelectorAll(".list-img");
    listImage.forEach((img) => {
        var a = $(img).attr("src");
        $(img).click(function () {
            $(".main-img-product").attr("src", a);
        });
    });
    $(".img-slide").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        centerMode: false,
        cssEase: "linear",
        accessibility: true,
        autoplay: true,
        autoplaySpeed: 900,
        vertical: true,
    });
    $(".img-slide-small").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        cssEase: "linear",
        accessibility: true,
        autoplay: true,
        autoplaySpeed: 900,
    });
});

var CurrentCount = parseInt($(".number-quantity").val());
$(".number-quantity").change(function () {
    CurrentCount = parseInt($(".number-quantity").val());
});
// tăng số lượng
$("#buttonUp").click(function () {
    if (CurrentCount <= 1) {
        CurrentCount = 1;
    }
    CurrentCount += 1;
    $(".number-quantity").val(CurrentCount);
});
// giảm số lượng
$("#buttonDown").click(function () {
    CurrentCount = CurrentCount - 1;
    if (CurrentCount <= 1) {
        $(".number-quantity").val("1");
    } else {
        $(".number-quantity").val(CurrentCount);
    }
});
$(".comment").hide();
$("#comment").click(function () {
    $(".thongtinchitiet").hide();
    $(".comment").show();
});
$("#mota").click(function () {
    $(".thongtinchitiet").show();
    $(".comment").hide();
});
function calculateCostOfProduct(cost, discount, count) {
    if (discount > 0) {
        return (cost - cost * (discount / 100)) * count;
    }
    return cost * count;
}
$("#buttonAddToCart").on("click", function () {
    var count = parseInt($("#countToAdd").val());
    if (!CheckToken) {
        alert("Vui lòng đăng nhập để có thể mua hàng");
        return;
    }
    var cost = parseFloat($(this).data("cost"));
    var discount = parseFloat($(this).data("discount"));
    const product = {
        idPro: $(this).data("id"),
        name: $(this).data("name"),
        cost: calculateCostOfProduct(cost, discount, count),
        discount: parseFloat($(this).data("discount")),
        image: $(this).data("image"),
        count: count,
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
