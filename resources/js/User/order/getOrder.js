const urlFetch = "/api/user/order";
const token = localStorage.getItem("authTokenPassport_user");
function formatCost(value) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
}
$.ajax({
    url: urlFetch,
    type: "GET",
    headers: {
        Authorization: "Bearer " + token,
    },
    success: function (res) {
        $(".totalOrder").text(res.length + " Đơn hàng");
        res.forEach((e) => {
            // console.log(e);
            // Browse each product in OrderDetail
            e.OrderDetail.forEach((a) => {
                var InforProduct = a.ProductDetail;
                var discountProduct = InforProduct.discount;
                var DetailProductPerOrder = null;
                if (discountProduct > 0)
                    var cost = formatCost(
                        InforProduct.cost -
                            InforProduct.cost * (InforProduct.discount / 100)
                    )(
                        (DetailProductPerOrder = `
             <div class="col-md-3 col-lg-3 col-xl-3 mb-4">
                                                                                <img src="/asset/img-add-product/${InforProduct.image_product[0].image}"
                                                                                    class="img-fluid rounded-3"
                                                                                    alt="Cotton T-shirt">
                                                                            </div>
                                                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                                                {{-- <h6 class="text-muted">Shirt</h6> --}}
                                                                                <h6 style="font-size:3vw;font-size:3vh"
                                                                                    class="mb-0">
                                                                                    ${InforProduct.namePro}
                                                                                </h6>
                                                                            </div>
                                                                            <div class="col-md-1 col-lg-1 col-xl-1 d-flex">
                                                                                <h5>x${InforProduct.number}</h5>
                                                                            </div>
                                                                            <div
                                                                                class="col-md-3 col-lg-3 col-xl-3 offset-lg-1 text-danger">
                                                                                    <h5>
                                                                                        ${cost}
                                                                                    </h5>
                                                                            </div>
            `)
                    );
                else {
                    var cost = formatCost(InforProduct.cost);
                    DetailProductPerOrder = `
             <div class="col-md-3 col-lg-3 col-xl-3 mb-4">
                                                                                <img src="/asset/img-add-product/${InforProduct.image_product[0].image}"
                                                                                    class="img-fluid rounded-3"
                                                                                    alt="Cotton T-shirt">
                                                                            </div>
                                                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                                                {{-- <h6 class="text-muted">Shirt</h6> --}}
                                                                                <h6 style="font-size:3vw;font-size:3vh"
                                                                                    class="mb-0">
                                                                                    ${InforProduct.namePro}
                                                                                </h6>
                                                                            </div>
                                                                            <div class="col-md-1 col-lg-1 col-xl-1 d-flex">
                                                                                <h5>x${InforProduct.number}</h5>
                                                                            </div>
                                                                            <div
                                                                                class="col-md-3 col-lg-3 col-xl-3 offset-lg-1 text-danger">
                                                                                    <h5><span
                                                                                            class="text-danger">${cost}</span>
                                                                                    </h5>
                                                                            </div>
            `;
                }
                $(".ListOrder").append(DetailProductPerOrder);
                console.log(a);
            });
            // console.log(e.OrderDetail);
        });
    },
    error: function (error) {
        console.log(error);
    },
});
