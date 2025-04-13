import { Delete, Update } from "../../util";

const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "product/update";
$("#ManageProduct").on("click", function () {
    $.ajax({
        url: "/admin/product",
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
        success: function (html) {
            // console.log("Admin page reloaded successfully");
            window.location.href = "/admin/product";
        },
        error: function (xhr) {
            console.log(xhr);
        },
    });
});
// Hàm thêm/xóa class valid/invalid
function addClassValid(nameId) {
    $(nameId).addClass("is-valid").removeClass("is-invalid");
}
function addClassInValid(nameId) {
    $(nameId).addClass("is-invalid").removeClass("is-valid");
}

// Validate tên sản phẩm
$("#namepro").on("change", function () {
    if ($(this).val().trim() !== "") {
        addClassValid(this);
    } else {
        addClassInValid(this);
    }
});

// Validate giá bán (chỉ chấp nhận số nguyên)
$("#giabanpro").on("change", function () {
    // Sửa "#countpro #giabanpro" thành "#giabanpro"
    const value = $(this).val();
    if (value && Number.isInteger(Number(value))) {
        addClassValid(this);
    } else {
        addClassInValid(this);
    }
});

// Xử lý upload ảnh
const $input = $("#imagepro");
let ListImageProduct = []; // Mảng lưu trữ danh sách file

$input.on("change", function (event) {
    const files = event.target.files;
    const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
    if (files && files.length > 0) {
        let validFiles = true;

        // Kiểm tra file hợp lệ
        Array.from(files).forEach((file) => {
            if (!allowedTypes.includes(file.type)) {
                validFiles = false;
                $.toast({
                    heading: "Lỗi",
                    text: `File "${file.name}" không phải là ảnh hợp lệ. Chỉ chấp nhận JPG, PNG, GIF, WebP.`,
                    showHideTransition: "slide",
                    icon: "error",
                    position: "bottom-right",
                });
            }
        });

        if (!validFiles) {
            $input.val("");
            ListImageProduct = [];
            return;
        }

        ListImageProduct = Array.from(files); // Chuyển FileList thành mảng
        console.log("Initial files:", ListImageProduct);

        // Hiển thị preview
        ListImageProduct.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgSrc = e.target.result;
                $(".image-preview").append(`
                    <div class="preview-container" id="preview-image-${index}">
                        <div class="preview-image">
                            <img src="${imgSrc}" alt="Ảnh đã chọn" class="preview-image" />
                            <button class="remove-btn" data-index="${index}" type="button">❌</button>
                        </div>
                    </div>
                `);
            };

            reader.readAsDataURL(file);
        });
        if (ListImageProduct.length === 0) {
            $input.val("");
        }
    }
});

// Xử lý xóa ảnh
$(".image-preview").on("click", ".remove-btn", async function () {
    const idImage = $(this).data("id");
    const index = $(this).data("index");
    // nếu không có id thì là ảnh vừa thêm
    if (!idImage) {
        if (index >= 0) {
            $(`#preview-image-${index}`).remove();
            ListImageProduct.splice(index, 1);
            const dataTransfer = new DataTransfer();
            ListImageProduct.forEach((file) => dataTransfer.items.add(file));
            $input[0].files = dataTransfer.files;
        }
        if (ListImageProduct.length === 0) {
            $input.val("");
        }
    } else {
        var data = {
            _token: csrfToken,
            id: idImage,
        };
        const response = await Delete("product/image/delete", data);
        console.log(response);
        if (response.message === "Xóa ảnh thành công") {
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            $(`#preview-image-${idImage}`).remove();
        } else {
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
        }
    }
});
// Cập nhật sản phẩm
$("#UpdateProForm").on("submit", async function (event) {
    event.preventDefault();
    if ($(".is-invalid").length > 0 || $(".preview-container").length < 0) {
        alert("Vui lòng nhập đầy đủ thông tin và hình ảnh sản phẩm !");
        return;
    } else {
        $(".loading-overlay").removeClass("d-none");
        var id = $("#idProHidden").val();
        var dataUpload = new FormData(this);
        dataUpload.append("_token", csrfToken);
        dataUpload.append("idPro", id);
        if (ListImageProduct.length > 0) {
            dataUpload.append("UpdateImage", "true");
            ListImageProduct.forEach((e, index) => {
                dataUpload.append(`imagepro[${index}]`, e);
            });
        }
        const response = await $.ajax({
            url: "/api/admin/" + urlFetch + "/" + id,
            type: "POST",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            data: dataUpload,
            processData: false,
            contentType: false,
        });
        console.log(response);
        if (response.message == "Cập nhật sản phẩm thành công") {
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            $(".loading-overlay").addClass("d-none");
            // // $("#AddProForm")[0].reset();
            // ListImageProduct = [];
            // $(".image-preview").empty();
        } else {
            $(".loading-overlay").addClass("d-none");
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
        }
    }
});
