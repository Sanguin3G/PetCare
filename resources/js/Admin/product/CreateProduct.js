import { Create } from "../../util";

const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "product/create";

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
    $(".image-preview").empty(); // Xóa preview cũ

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
        var index = 0;
        ListImageProduct.forEach((file) => {
            const reader = new FileReader();
            index = index++;
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
    }
});

// Xử lý xóa ảnh
$(".image-preview").on("click", ".remove-btn", function () {
    const index = $(this).data("index");
    if (index >= 0 && index < ListImageProduct.length) {
        $(`#preview-image-${index}`).remove();
        ListImageProduct.splice(index, 1);

        const dataTransfer = new DataTransfer();
        ListImageProduct.forEach((file) => dataTransfer.items.add(file));
        $input[0].files = dataTransfer.files;
        if (ListImageProduct.length === 0) {
            $input.val("");
        }
    }
});

// tạo mới sản phẩm
$("#AddProForm").on("submit", async function (event) {
    event.preventDefault();
    if ($(".is-invalid").length > 0 || ListImageProduct.length <= 0) {
        alert("Vui lòng nhập đầy đủ thông tin !");
        return;
    } else {
        var dataUpload = new FormData(this);
        dataUpload.append("_token", csrfToken);
        ListImageProduct.forEach((e, index) => {
            dataUpload.append(`imagepro[${index}]`, e);
        });
        const response = await $.ajax({
            url: "/api/admin/" + urlFetch,
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
        if (response.message == "Thêm sản phẩm thành công") {
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            $("#AddProForm")[0].reset();
            ListImageProduct = [];
            $(".image-preview").empty();
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
