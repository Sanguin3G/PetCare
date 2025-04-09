import { Update } from "../../util";
const csrfToken = $('meta[name="csrf-token"]').attr("content");
const urlFetch = "category/update";
$("#table-category").on(
    "click",
    ".buttonUpdateCategory",
    async function (event) {
        event.preventDefault();
        var id = $(this).data("id");
        var name = $(`#nameCatUpdate${id}`).val().trim();
        console.log(name);
        if (name !== "") {
            var id = $(this).data("id");
            if (id > 0) {
                const response = await Update(urlFetch, {
                    _token: csrfToken,
                    idCat: id,
                    name: name,
                });
                console.log(response);
                if (response.message === "Cập nhật danh mục thành công") {
                    $("#table-category tr").each(function () {
                        var rowId = $(this).find("td:first").text().trim(); // Lấy ID từ cột đầu tiên
                        if (rowId == id) {
                            $(this).find("td:eq(1)").text(name);
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
                console.log(false);
                return;
            }
        } else {
            alert("Vui lòng nhập tên danh mục");
            return;
        }
    }
);
