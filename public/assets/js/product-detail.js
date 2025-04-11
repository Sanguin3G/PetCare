$(document).ready(function () {
    var listImage = document.querySelectorAll(".list-img");
    listImage.forEach((img) => {
        var a = $(img).attr("src");
        $(img).click(function () {
            $(".main-img-product").attr("src", a);
        });
    });
    $(".img-slide").slick({
        slidesToShow: 2,
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
});
