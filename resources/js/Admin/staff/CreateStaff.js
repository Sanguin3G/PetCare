const UrlFetchCreateStaff = "/api/admin/createStaff";
$(".error-name, .error-phone, .error-email, .error-cccd").hide();
var file = null;
// hiển thị ảnh đã chọn
$("#uploadImgNV").on("change", function (event) {
    file = event.target.files[0];
    if (
        file &&
        (file.type === "image/jpeg" ||
            file.type === "image/png" ||
            file.type === "image/jpg")
    ) {
        $(".error-image").addClass("d-none");
        const reader = new FileReader();
        reader.onload = function (e) {
            $(".image-preview").removeClass("d-none");
            $(".image-preview img").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        $(".error-image").removeClass("d-none");
        event.target.value = ""; // Reset file input
        $(".image-preview img").attr("src", e.target.result);
        $(".image-preview").addClass("d-none");
    }
});
// xóa ảnh
$("#removeImage").on("click", function () {
    $("#uploadImgNV").val("");
    $(".image-preview img").attr("src", "");
    $(".image-preview").addClass("d-none");
});
// upload
$("#FormCreateStaff").on("submit", function (event) {
    event.preventDefault();
    if (file !== null && $(".is-invalid").length <= 0) {
        const formData = new FormData();
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        formData.append("nameNV", $("#nameNV").val());
        formData.append("emailNV", $("#emailNV").val());
        formData.append("localNV", $("#localNV").val());
        formData.append("phoneNV", $("#phoneNV").val());
        formData.append("dateNV", $("#dateNV").val());
        formData.append("CMND", $("#CMND").val());
        formData.append("sex", $("#sex").val());
        formData.append("chucvu", $('input[name="chucvu"]').val());
        formData.append("image", file);
        $.ajax({
            url: UrlFetchCreateStaff,
            type: "POST",
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (response) {
                console.log(response);
            },
            error: function (response) {
                console.log(response);
            },
        });
    } else {
        alert("Vui lòng nhập đầy đủ thông tin");
    }
});
$("#nameNV").on("change", function () {
    const regex =
        /^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz\s]+$/;
    var name = $(this).val();
    var check = regex.test(name);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
        $(".error-name").removeClass("d-none");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
        $(".error-name").addClass("d-none");
    }
});
$("#emailNV").on("change", function () {
    const regex =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var email = $(this).val();
    var check = regex.test(email);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
        $(".error-email").removeClass("d-none");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
        $(".error-email").addClass("d-none");
    }
});
$("#phoneNV").on("change", function () {
    const regex =
        /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
    var phone = $(this).val();
    var check = regex.test(phone);
    if (check) {
        $(this).removeClass("is-invalid").addClass("is-valid");
        $(".error-phone").removeClass("d-none");
    } else {
        $(this).removeClass("is-valid").addClass("is-invalid");
        $(".error-phone").addClass("d-none");
    }
});
