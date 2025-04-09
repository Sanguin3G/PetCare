import { Delete } from "../../util";
const csrfToken = $('meta[name="csrf-token"]').attr("content");
const urlFetch = "category/delete";
$("#table-category").on(
    "click",
    ".buttonDeleteCategory",
    async function (event) {
        if (confirm("Xác nhận xóa danh mục ?")) {
            var id = $(this).data("id");
            console.log(id);
            if (id > 0) {
                const response = await Delete(urlFetch, {
                    _token: csrfToken,
                    idCat: id,
                });
                if (response.message == "Xóa danh mục thành công") {
                    $("#table-category tr").each(function () {
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
                } else {
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                }
            } else {
                console.log(1);
                return;
            }
        }
    }
);
