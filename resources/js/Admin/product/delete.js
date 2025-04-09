import { Delete } from "../../util";
const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "product/delete";

$("#table-product").on("click", ".button-delete-product", async function () {
    if (confirm("Xác nhận xóa sản phẩm này ?")) {
        $(".loading-overlay").removeClass("d-none");
        var id = $(this).data("id");
        var data = {
            idPro: id,
            _token: csrfToken,
        };
        const response = await Delete(urlFetch, data);
        if (response.message === "Xóa sản phẩm thành công") {
            $("#table-product tr").each(function () {
                var rowId = $(this).find("td:first").text().trim(); // Lấy ID từ cột đầu tiên
                if (rowId == id) {
                    $(this).remove(); // Xóa dòng có ID trùng
                }
            });
            $.toast({
                heading: "Thông báo",
                text: response.message,
                showHideTransition: "slide",
                icon: response.status,
                position: "bottom-right",
            });
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
    }
});
