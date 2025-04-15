import { Get } from "../../util";

const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "product/get";
$(document).on("click", ".page-link-product", async function () {
    console.log(1);
    $(".loading-overlay").removeClass("d-none");
    var page = $(this).data("page");
    var textFind = $("#searchProduct").val().toLowerCase().trim();
    var data = {
        _token: csrfToken,
        text: textFind,
    };
    if (textFind === "") {
        const response = await Get(urlFetch + "?page=" + page, data);
        console.log(response.data);
        if (response.data.product !== null) {
            $("#table-product").empty();
            response.data.product.forEach((e) => {
                var imageProduct = e.image_product[0];
                var image = imageProduct.image;
                $("#table-product").append(`
                            <tr class="text-center">
                                <td>${e.idPro}</td>
                                <td>${e.namePro}</td>
                                <td class="text-center">
                                    ${
                                        e.image_product &&
                                        e.image_product.length > 0
                                            ? `<img src="/assets/img-add-pro/${image}" style="width:10vw;height:auto" alt="${e.namePro}">`
                                            : ""
                                    }
                                </td>
                                <td>${e.count}</td>
                                <td>
                                    ${
                                        e.count > 0
                                            ? '<button class="btn btn-success">Còn hàng</button>'
                                            : '<button class="btn btn-danger">Hết hàng</button>'
                                    }
                                </td>
                                <td>${Number(e.cost).toLocaleString(
                                    "vi-VN"
                                )} đ</td>
                                <td>${
                                    e.discount > 0 ? e.discount + "%" : ""
                                }</td>
                                <td>${
                                    e.hot > 0
                                        ? '<i class="fa-solid fa-check" style="color: #06e302;"></i>'
                                        : ""
                                }</td>
                                <td class="table-td-center">
                                    <button style="font-size:2vw;font-size:2vh" 
                                            class="btn btn-danger btn-sm trash button-delete-product" 
                                            data-id="${e.idPro}" 
                                            type="button" 
                                            title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button style="font-size:2vw;font-size:2vh" 
                                            class="btn btn-success btn-sm edit" 
                                            type="button" 
                                            title="Sửa">
                                        <a style="text-decoration:none;color:white" 
                                           href="/admin/product/change/${
                                               e.idPro
                                           }/${e.namePro
                    .toLowerCase()
                    .replace(/\s+/g, "-")}"}>
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        `);
            });
            $(".loading-overlay").addClass("d-none");
            var currentPage = response.data.current_page;
            var lastPage = response.data.last_page;

            // update status active of pagination
            $(".pagination .page-item").removeClass("active");
            $(`.pagination .page-link[data-page="${currentPage}"]`)
                .parent()
                .addClass("active");

            // update disabled for Previous/Next
            $(".pagination .page-item").removeClass("disabled");
            if (currentPage === 1) {
                $(
                    '.pagination .page-link[data-page="' +
                        (currentPage - 1) +
                        '"]'
                )
                    .parent()
                    .addClass("disabled");
            }
            if (currentPage === lastPage) {
                $(
                    '.pagination .page-link[data-page="' +
                        (currentPage + 1) +
                        '"]'
                )
                    .parent()
                    .addClass("disabled");
            }
            return;
        }
        $.toast({
            heading: "Thông báo",
            text: "Có lỗi trong quá trình lấy dữ liệu",
            showHideTransition: "slide",
            icon: "error",
            position: "bottom-right",
        });
        $(".loading-overlay").addClass("d-none");
        return;
    }
    // if text search no null, find by name
    $.ajax({
        url: `/api/auth/product/findBySearch?page=${page}`,
        type: "POST",
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
            "Content-Type": "application/json; charset=UTF-8",
        },
        data: JSON.stringify(data),
        cache: false,
        success: function (response) {
            try {
                $(".loading-overlay").addClass("d-none");
                if (response.data && response.data.product) {
                    var result = response.data;
                    var totalPage = result.last_page || 1;
                    let paginationHtml = "";
                    for (var i = 1; i <= totalPage; i++) {
                        paginationHtml += `
                            <li class="page-item ${
                                i === (result.current_page || 1) ? "active" : ""
                            }">
                                <button class="page-link page-link-product" data-page="${i}">${i}</button>
                            </li>
                        `;
                    }
                    $(".pagination").html(paginationHtml);
                    // Build table HTML
                    let tableHtml = "";
                    result.product.forEach((e) => {
                        var imageProduct = e.image_product?.[0];
                        var image = imageProduct?.image || "default-image.jpg";
                        tableHtml += `
                            <tr class="text-center">
                                <td>${e.idPro || ""}</td>
                                <td>${e.namePro || ""}</td>
                                <td class="text-center">
                                    ${
                                        e.image_product &&
                                        e.image_product.length > 0
                                            ? `<img src="/assets/img-add-pro/${image}" style="width:10vw;height:auto" alt="${
                                                  e.namePro || "Product"
                                              }">`
                                            : ""
                                    }
                                </td>
                                <td>${e.count || 0}</td>
                                <td>
                                    ${
                                        (e.count || 0) > 0
                                            ? '<button class="btn btn-success">Còn hàng</button>'
                                            : '<button class="btn btn-danger">Hết hàng</button>'
                                    }
                                </td>
                                <td>${Number(e.cost || 0).toLocaleString(
                                    "vi-VN"
                                )} đ</td>
                                <td>${
                                    e.discount > 0 ? e.discount + "%" : ""
                                }</td>
                                <td>${
                                    e.hot > 0
                                        ? '<i class="fa-solid fa-check" style="color: #06e302;"></i>'
                                        : ""
                                }</td>
                                <td class="table-td-center">
                                    <button style="font-size:2vw;font-size:2vh"
                                            class="btn btn-danger btn-sm trash button-delete-product"
                                            data-id="${e.idPro || ""}"
                                            type="button"
                                            title="Xóa"
                                            aria-label="Xóa sản phẩm">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button style="font-size:2vw;font-size:2vh"
                                            class="btn btn-success btn-sm edit"
                                            type="button"
                                            title="Sửa"
                                            aria-label="Sửa sản phẩm">
                                        <a style="text-decoration:none;color:white"
                                           href="/admin/product/change/${
                                               e.idPro || ""
                                           }/${(e.namePro || "")
                            .toLowerCase()
                            .replace(/\s+/g, "-")}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#table-product").html(tableHtml);
                    // Update pagination states
                    var currentPage = result.current_page || 1;
                    var lastPage = result.last_page || 1;
                    $(".pagination .page-item").removeClass("active disabled");
                    $(`.pagination .page-link[data-page="${currentPage}"]`)
                        .parent()
                        .addClass("active");
                    if (currentPage === 1) {
                        $(
                            `.pagination .page-link[data-page="${
                                currentPage - 1
                            }"]`
                        )
                            .parent()
                            .addClass("disabled");
                    }
                    if (currentPage === lastPage) {
                        $(
                            `.pagination .page-link[data-page="${
                                currentPage + 1
                            }"]`
                        )
                            .parent()
                            .addClass("disabled");
                    }
                } else {
                    $("#table-product").html(
                        "<tr><td colspan='9'>No products found</td></tr>"
                    );
                    $(".pagination").empty();
                }
            } catch (error) {
                console.error("Error in success callback:", error);
                $(".loading-overlay").addClass("d-none");
            }
        },
        error: function (error) {
            console.log("AJAX error:", error);
            $(".loading-overlay").addClass("d-none");
            alert("Something went wrong");
        },
    });
});
