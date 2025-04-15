const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "/api/admin/order/detail/get";
$(".btn-getdetail-order").on("click", function () {
    $(".loading-overlay").removeClass("d-none");
    var id = $(this).data("id");
    $.ajax({
        url: urlFetch + `/${id}`,
        headers: {
            Authorization: "Bearer " + TokenApi,
        },
        type: "GET",
        success: function (response) {
            if (!response.data) {
                $(".main").empty();
                $(".main").append(response);
                $(".loading-overlay").addClass("d-none");
                return;
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
});
$(".btn-đelivery").on("click", function () {
    const urlFetch = "/api/admin/order/delivery";
    if (confirm("Xác nhận giao hàng ?")) {
        $(".loading-overlay").removeClass("d-none");
        var id = $(this).data("id");
        $.ajax({
            url: urlFetch + `/${id}`,
            headers: {
                Authorization: "Bearer " + TokenApi,
            },
            type: "PATCH",
            data: {
                _token: csrfToken,
            },
            success: function (response) {
                if (response.status === "success") {
                    $.toast({
                        heading: "Thông báo",
                        text: "Confirm Order Successfully",
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                    const $row = $(`button[data-id='${id}']`).closest("tr");
                    $row.find("td.btn-no-delivery").html(`
            <button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-delivery-success">Đã giao hàng</button>
        `);
                    $(".loading-overlay").addClass("d-none");
                    return;
                }
                $.toast({
                    heading: "Thông báo",
                    text: "Has some wrong",
                    showHideTransition: "slide",
                    icon: response.status,
                    position: "bottom-right",
                });
                $(".loading-overlay").addClass("d-none");
            },
            error: function (error) {
                console.log(error);
            },
        });
    }
    return;
});
