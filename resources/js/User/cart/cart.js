import { Create } from "../../util";
const email = localStorage.getItem("Email_User")
    ? localStorage.getItem("Email_User")
    : null;

var cart = JSON.parse(localStorage.getItem(`cart_${email}`)) || [];
export const getCart = function () {
    return cart;
};

export const saveCart = function (NewCart) {
    localStorage.setItem(`cart_${email}`, JSON.stringify(NewCart));
};

export const Add = function (item) {
    try {
        var product = cart.find((e) => e.idPro === item.idPro);
        if (product) {
            product.count += item.count;
        } else {
            cart.push(item);
        }
        localStorage.setItem(`cart_${email}`, JSON.stringify(cart));
        return true;
    } catch (e) {
        return false;
    }
};

export const Del = function (id) {
    try {
        cart = cart.filter((e) => e.idPro != id);
        localStorage.setItem(`cart_${email}`, JSON.stringify(cart));
        return true;
    } catch (e) {
        return false;
    }
};

export const DestroyCart = function () {
    try {
        localStorage.removeItem(`cart_${email}`);
        return true;
    } catch (e) {
        return false;
    }
};

export const Increase = function (id, number) {
    try {
        var item = cart.find((e) => e.idPro === id);
        if (item) {
            item.count += number;
            localStorage.setItem(`cart_${email}`, JSON.stringify(cart));
            return item.count;
        } else {
            return false;
        }
    } catch (e) {
        return false;
    }
};

export const Decrease = function (id, number) {
    try {
        var item = cart.find((e) => e.idPro === id);
        if (item) {
            if (item.count > 1) {
                item.count -= number;
                localStorage.setItem(`cart_${email}`, JSON.stringify(cart));
            }
            return item.count;
        } else {
            return false;
        }
    } catch (e) {
        return false;
    }
};

export const TotalItemCart = function () {
    return cart.length;
};

export const TotalCostInCart = function () {
    var cost = 0;
    cart.forEach((e) => {
        if (e.discount > 0) {
            cost += (e.cost - e.cost * (e.discount / 100)) * e.count;
        } else {
            cost += e.count * e.cost;
        }
    });
    return formatCost(cost);
};
export const CalculateCostOfProduct = function (id) {
    var e = cart.find((a) => a.idPro === id);
    if (e) {
        var cost = 0;
        if (e.discount > 0) {
            cost += (e.cost - e.cost * (e.discount / 100)) * e.count;
        } else {
            cost += e.count * e.cost;
        }
        return cost;
    }
};
function formatCost(value) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
}

function updateCostInView() {
    if (TotalItemCart() > 0) {
        $("#ListProductInCart").removeClass("d-none");
        $(".right-part-cart").removeClass("d-none");
        $(".CountTotalCost").text(TotalCostInCart());
        $("#totalcost").text(TotalCostInCart());
    } else {
        $("#ListProductInCart").addClass("d-none");
        $(".right-part-cart").addClass("d-none");
    }
}
export const renderCart = function () {
    try {
        $(".payment1-detail , .payment2-detail, .payment3-detail").hide();
        // toogle phương thức thanh toán
        var payment_COD = document.getElementById("payment1");
        var payment_banking = document.getElementById("payment2");
        var payment_vnpay = document.getElementById("payment3");
        if (payment_COD.checked) {
            $(".payment3-detail").hide();
            $(".payment2-detail").hide();
            $(".payment1-detail").show();
            payment_Method = "Thanh toán bằng phương thức COD";
        }
        if (payment_banking.checked) {
            $(".payment1-detail").hide();
            $(".payment2-detail").show();
            $(".payment3-detail").hide();
            payment_Method = "Thanh toán bằng phương thức chuyển khoản";
        }
        if (payment_vnpay.checked) {
            $(".payment1-detail").hide();
            $(".payment3-detail").show();
            $(".payment2-detail").hide();
            payment_Method = "Thanh toán bằng VNPAY";
        }
        // Lắng nghe sự kiện thay đổi lựa chọn phương thức thanh toán
        $("input[name='payment']").change(function () {
            // Ẩn tất cả các chi tiết thanh toán trước khi hiển thị chi tiết của phương thức thanh toán được chọn
            $(".payment1-detail, .payment2-detail").hide();

            // Kiểm tra phương thức thanh toán được chọn và hiển thị chi tiết tương ứng
            if ($("#payment1").prop("checked")) {
                $(".payment1-detail").show();
            } else if ($("#payment2").prop("checked")) {
                $(".payment2-detail").show();
            } else if ($("#payment3").prop("checked")) {
                $(".payment3-detail").show();
            }
        });
        $("#countItemInCart").text(TotalItemCart() + " Sản phẩm");
        if (TotalItemCart() > 0) {
            $("#ListProductInCart").removeClass("d-none");
            $(".right-part-cart").removeClass("d-none");
            $(".CountTotalCost").text(TotalCostInCart());
            $("#totalcost").text(TotalCostInCart());
            $("#pay-form").removeClass("d-none");
        } else {
            $("#ListProductInCart").addClass("d-none");
            $(".right-part-cart").addClass("d-none");
        }
        $("#ListProductInCart").empty();
        cart.forEach((e, index) => {
            // nếu có giảm giá thì thêm item giá tiền tính theo giảm giá
            var totalCost = 0;
            if (e.discount > 0) {
                totalCost = formatCost(
                    (e.cost - e.cost * (e.discount / 100)) * e.count
                );
            } else {
                totalCost = formatCost(e.count * e.cost);
            }
            $("#ListProductInCart")
                .append(`<div class="row mb-4 d-flex justify-content-between align-items-center item_${e.idPro}">
                            <div class="col-md-2 col-lg-2 col-xl-3">
                              <img src="${e.image}" class="img-fluid rounded-3"
                                alt="Cotton T-shirt">
                            </div>
                            <div class="col-md-3 col-lg-3 col-xl-3">

                              <h6 class="mb-0"><input value="${e.idPro}" name="id${e.idPro}" hidden>
                                ${e.name}</h6>
                            </div>
                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                              <div class="number-control">
                                <div class="number-left me-2" data-id="${e.idPro}"></div>
                                <input style="width:50%" type="number" name="${e.idPro}"
                                  id="Count_idPro_${e.idPro}" min="1" value="${e.count}"
                                  required="không để trống">
                                <div class="number-right ms-2" data-id="${e.idPro}"
                                  id="buttonUp${e.idPro}"></div>
                              </div>
                            </div>
                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                              <h6 class="mb-0 costProduct" id="CostCartProduct${e.idPro}">
                                 ${totalCost}
                              </h6>
                            </div>
                            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                              <button type="button" class="text-muted delete-item" data-id="${e.idPro}"><i
                                  class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <hr class="my-4">`);
        });
        // xóa sản phẩm khỏi giỏ hàng
        $(".delete-item").on("click", function () {
            var id = $(this).data("id");
            console.log(id);
            if (confirm("Xác nhận xóa sản phẩm này khỏi giỏ hàng ?")) {
                var result = Del(id);
                if (result) {
                    $.toast({
                        heading: "Thông báo",
                        text: "Xóa sản phẩm khỏi giỏ hành thành công",
                        showHideTransition: "slide",
                        icon: "success",
                        position: "bottom-right",
                    });
                    $(".item_" + id).addClass("d-none");
                    updateCostInView();
                } else {
                    $.toast({
                        heading: "Thông báo",
                        text: "Có lỗi xảy ra !",
                        showHideTransition: "slide",
                        icon: "error",
                        position: "bottom-right",
                    });
                }
            }
        });
        // tăng số lượng sản phẩm
        $(".number-right").on("click", function () {
            var id = $(this).data("id");
            var result = Increase(id, 1);
            var originNum = $("#Count_idPro_" + id).val();
            if (result !== false) {
                $("#Count_idPro_" + id).val(result);
                var CostAfterChange = formatCost(CalculateCostOfProduct(id));
                $("#CostCartProduct" + id).text(CostAfterChange);
                updateCostInView();
            } else {
                $("#Count_idPro_" + id).val(originNum);
            }
        });
        // giảm số lượng sản phẩm
        $(".number-left").on("click", function () {
            var id = $(this).data("id");
            var result = Decrease(id, 1);
            var originNum = $("#Count_idPro_" + id).val();
            if (result !== false) {
                $("#Count_idPro_" + id).val(result);
                var CostAfterChange = formatCost(CalculateCostOfProduct(id));
                $("#CostCartProduct" + id).text(CostAfterChange);
                updateCostInView();
            } else {
                $("#Count_idPro_" + id).val(originNum);
            }
        });
        // thanh toán giỏ hàng
        $(".form-checkout-cart").on("submit", function (event) {
            event.preventDefault();
            $(".loading-overlay").removeClass("d-none");
            const apiFetch = "/api/user/cart/checkout";
            const csfrToken = $('meta[name="csrf-token"]').attr("content");
            const passportToken = localStorage.getItem(
                "authTokenPassport_user"
            );
            var payment_COD = document.getElementById("payment1");
            var payment_banking = document.getElementById("payment2");
            var payment_vnpay = document.getElementById("payment3");
            var payment_Method = null;
            if (payment_COD.checked) {
                payment_Method = "Thanh toán bằng phương thức COD";
            }
            if (payment_banking.checked) {
                payment_Method = "Thanh toán bằng phương thức chuyển khoản";
            }
            if (payment_vnpay.checked) {
                payment_Method = "Thanh toán bằng VNPAY";
            }
            var data = {
                _token: csfrToken,
                BankCode: $("#bankCode").val().trim(),
                Language: $("#language").val().trim(),
                Name: $("#name").val().trim(),
                Phone: $("#phonenumber").val().trim(),
                Address: $("#address").val().trim(),
                IdVoucher: $("#idVoucher").val().trim(),
                DiscountVoucher: 20,
                Note: $("#description").val().trim(),
                Method_Payment: payment_Method,
                Total: TotalCostInCart(),
                Cart: cart,
            };
            $.ajax({
                url: apiFetch,
                type: "POST",
                headers: {
                    Authorization: "Bearer " + passportToken,
                },
                data: data,
                success: function (response) {
                    if (response.status === "success") {
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                        DestroyCart();
                        $("#ListProductInCart").addClass("d-none");
                        $(".right-part-cart").addClass("d-none");
                        $("#name").val("");
                        $("#phonenumber").val("");
                        $("#address").val("");
                        $("#description").val("");
                        $(".totalInCart").addClass("d-none");
                        $("#pay-form").addClass("d-none");
                        $(".loading-overlay").addClass("d-none");
                    } else {
                        $.toast({
                            heading: "Thông báo",
                            text: response.message,
                            showHideTransition: "slide",
                            icon: response.status,
                            position: "bottom-right",
                        });
                        $(".loading-overlay").addClass("d-none");
                    }
                },
            });
        });
    } catch (e) {
        console.log(e);
    }
};
// renderCart();
// var flag = false;
// $(document).ready(function () {
//     if (!flag) {
//         renderCart();
//         flag = true;
//     }
// });
