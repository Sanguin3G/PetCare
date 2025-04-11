const urlFetch = "/api/user/product";
const token = localStorage.getItem("authTokenPassport_user");
var category = null;
var Field_sort = "idPro";
var type_sort = "desc";
var idCat = $("#FirstIdCatHidden").val();
function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/\-\-+/g, "-")
        .replace(/^-+/, "")
        .replace(/-+$/, "");
}
function formatCost(value) {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
    }).format(value);
}
$(".sort-button").on("click", function () {
    Field_sort = $(this).data("field");
    type_sort = $(this).data("order");
    fetchDataProduct(Field_sort, type_sort, idCat);
});
// lấy danh mục
$(".button-category-item").on("click", function () {
    idCat = $(this).data("id");
    fetchDataProduct(Field_sort, type_sort, idCat);
});
function fetchDataProduct(field, sort, idCat) {
    try {
        $.ajax({
            url:
                urlFetch +
                `?field=${Field_sort}&sort=${type_sort}&category=${idCat}`,
            headers: {
                Authorization: "Bearer " + token,
            },
            type: "GET",
            success: function (response) {
                if (response.status === "success") {
                    console.log(response);
                    $(".product-list").empty();
                    // console.log(response)
                    response.data.forEach(function (product) {
                        var image = product.image_product[0].image;
                        var slugName = slugify(product.namePro);
                        if (product.discount == null) {
                            $(".product-list").append(`
            <div id="product-infor" class="card position-relative" style="max-width:15rem;height:27rem" style="border:0px">
              <div>
                <a id="img_pro" href="/product/detail/${
                    product.idPro
                }/${slugName}"> <img class="card-img-top img-fluid p-2"
                    style="max-height:20rem" src="/assets/img-add-pro/${image}" alt="Card image cap"></a>
              </div>
              <div class="onsale position-absolute top-0 start-0">
            
              </div>
              <div class="card-body" id="card-body">
                <h6 id="name-product" class="card-title">
                  ${product.namePro}
                </h6>
            
                <span class="rating secondary-font">
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  5.0</span>
                <p class="card-text text-danger ">
                  ${formatCost(product.cost)}
                </p>
                <a href="cart/addPro/${
                    product.idPro
                }" style="text-decoration:none;color:white"><button type="submit"
                    style="position:absolute;top:0;right:0" class="btn btn-white shadow-sm rounded-pill"><i style="color:black"
                      class="fa-solid fa-cart-shopping text-danger"></i></button></a>
              </div>
            </div>
            `);
                        } else {
                            $(".product-list").append(`
            <div id="product-infor" class="card position-relative" style="max-width:15rem;height:27rem" style="border:0px"> 
             <div class="onsale position-absolute top-0 start-0">
                                <span class="badge rounded-0 bg-danger"><i class="fa-solid fa-arrow-down"></i>
                                    ${product.discount}%
                                </span>
                            </div>           
              <div>
                <a id="img_pro" href="/product/detail/${
                    product.idPro
                }/${slugName}"> <img class="card-img-top img-fluid p-2"
                    style="max-height:20rem" src="/assets/img-add-pro/${image}"alt="Card image cap"></a>
              </div>
              <div class="card-body" id="card-body">
                <h6 id="name-product" class="card-title">
                  ${product.namePro}
            
                </h6>
                <span class="rating secondary-font">
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  <i class="fa-solid fa-star text-warning"></i>
                  5.0</span>
            
                <p class="card-text text-danger text-decoration-line-through">
                  ${formatCost(product.cost)}
                </p>
                <p class="card-text text-danger" style="margin-top:-15px">
                  ${formatCost(
                      parseInt(
                          product.cost - product.cost * (product.discount / 100)
                      )
                  )}
                </p>
            
                <a style="text-decoration:none;color:white"><button type="submit"
                    style="position:absolute;top:0;right:0" class="btn btn-white shadow-sm rounded-pill"><i style="color:black"
                      class="fa-solid fa-cart-shopping text-danger"></i></button></a>
              </div>
            </div>
            `);
                        }
                    });
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    } catch (e) {
        alert("Có lỗi xảy ra");
    }
}
