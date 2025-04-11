import { Create } from "../../util";

const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "service/create";

// Hàm thêm/xóa class valid/invalid
function addClassValid(nameId) {
    $(nameId).addClass("is-valid").removeClass("is-invalid");
}
function addClassInValid(nameId) {
    $(nameId).addClass("is-invalid").removeClass("is-valid");
}

// Validate tên sản phẩm
$("#nameDM").on("change", function () {
    if ($(this).val().trim() !== "") {
        addClassValid(this);
    } else {
        addClassInValid(this);
    }
});
var file = null;
// Xử lý upload ảnh
$("#imageService").on("change", function (event) {
    const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/webp"];
    $(".image-preview").empty(); // Xóa preview cũ
    file = event.target.files[0];
    if (file) {
        if (!allowedTypes.includes(file.type)) {
            $.toast({
                heading: "Lỗi",
                text: `File "${file.name}" không phải là ảnh hợp lệ. Chỉ chấp nhận JPG, PNG, GIF, WebP.`,
                showHideTransition: "slide",
                icon: "error",
                position: "bottom-right",
            });
            event.target.value = ""; // Reset file input
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            $(".image-preview").append(`
                    <div class="preview-container">
                        <div class="preview-image">
                            <img src="${e.target.result}" alt="Ảnh đã chọn" class="preview-image" />
                            <button class="remove-btn" type="button">❌</button>
                        </div>
                    </div>
                `);
        };
        reader.readAsDataURL(file);
    }
});

// Xử lý xóa ảnh
$(".image-preview").on("click", ".remove-btn", function () {
    $("#imageService").val("");
    $(".image-preview").empty();
    file = null;
});

// tạo mới sản phẩm
$("#AddServiceForm").on("submit", async function (event) {
    event.preventDefault();
    if ($(".is-invalid").length > 0 || file === null) {
        alert("Vui lòng nhập đầy đủ thông tin !");
        return;
    } else {
        $(".loading-overlay").removeClass("d-none");
        var dataUpload = new FormData(this);
        dataUpload.append("_token", csrfToken);
        dataUpload.append(`imageService`, file);
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
        if (response.message == "Thêm dịch vụ thành công !") {
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
            $("#AddServiceForm")[0].reset();
            $(".image-preview").empty();
            $(".loading-overlay").addClass("d-none");
            $("#nameDM").removeClass("is-valid");
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
    }
});
