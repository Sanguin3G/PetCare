window.onload = function () {
    $(document).ready(function () {
        $(".carouselHome").slick({
            slidesToShow: 6,
            slideToScroll: 6,
            dots: true,
            arrows: true,
            cssEase: "linear",
            accessibility: true,
            autoplay: true,
            autoplaySpeed: 600,
            responsive: [
                {
                    breakpoint: 1400,
                    settings: {
                        slidesToShow: 4,
                        dots: true,
                        arrows: true,
                        cssEase: "linear",
                        accessibility: true,
                        autoplay: true,
                        autoplaySpeed: 600,
                    },
                },

                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: true,
                        cssEase: "linear",
                        accessibility: true,
                        autoplay: true,
                        autoplaySpeed: 600,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: true,
                        cssEase: "linear",
                        accessibility: true,
                        autoplay: true,
                        autoplaySpeed: 600,
                    },
                },
            ],
        });

        // voucher
        $(".carouselVoucher").slick({
            slidesToShow: 4,
            slideToScroll: 4,
            dots: true,
            arrows: true,
            cssEase: "linear",
            accessibility: true,
            autoplay: true,
            autoplaySpeed: 600,
            responsive: [
                {
                    breakpoint: 1400,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: true,
                        cssEase: "linear",
                        accessibility: true,
                        autoplay: true,
                        autoplaySpeed: 600,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: true,
                        cssEase: "linear",
                        accessibility: true,
                        autoplay: true,
                        autoplaySpeed: 600,
                    },
                },
            ],
        });
    });
};
