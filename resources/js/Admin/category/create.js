const csrfToken = $('meta[name="csrf-token"]').attr("content");
const TokenApi = localStorage.getItem("authTokenPassport");
const urlFetch = "/api/admin/category/create";
$("#formCreateCategory").on("submit", function (event) {
    event.preventDefault();
    var name = $("#nameCategory").val();
    if (name == "") {
        alert("Vui lòng nhập tên danh mục");
        return;
    } else {
        $.ajax({
            url: urlFetch,
            type: "POST",
            data: {
                _token: csrfToken,
                name: name,
            },
            headers: {
                Authorization:
                    "Bearer " + localStorage.getItem("authTokenPassport"),
            },
            success: function (response) {
                console.log(response);
                if (response.message == "Thêm danh mục thành công") {
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                    $("#table-category").append(`
                     <tr>
                                <td>${response.data.idCat}</td>
                                <td>${response.data.name}</td>

                                <td class="table-td-center">
                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-danger btn-sm trash buttonDeleteCategory"
                                       data-id="${response.data.idCat}" type="button">
                                        <a style="color:white"> <i class="fas fa-trash-alt"></i></a>
                                    </button>

                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-sm edit"
                                        type="button" title="Sửa" id="show-emp" data-bs-toggle="modal"
                                        data-bs-target="#update${response.data.idCat}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <div class="modal fade" id="update${response.data.idCat}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 style="font-size:2vw;font-size:2vh" class="modal-title fs-5"
                                                        id="exampleModalLabel">Thông báo
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                 <form id="formUpdateCategory" data-id="${response.data.idCat}">
                                                   <div class="modal-body">
                                                    <p>Tên danh mục</p>
                                                    <input style="font-size:2vw;font-size:2vh" class="form-control"
                                                        type='text' name='nameCat' id="nameCatUpdate${response.data.idCat}"
                                                        value="${response.data.name}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button style="font-size:2vw;font-size:2vh" type="button"
                                                        class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button style="font-size:2vw;font-size:2vh"
                                                        class="btn btn-primary buttonUpdateCategory"
                                                        data-id="${response.data.idCat}"><a
                                                            style="text-decoration:none;color:white">Đồng
                                                            ý</a></button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    `);
                } else {
                    $.toast({
                        heading: "Thông báo",
                        text: response.message,
                        showHideTransition: "slide",
                        icon: response.status,
                        position: "bottom-right",
                    });
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    }
});
