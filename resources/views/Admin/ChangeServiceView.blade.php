@extends('Admin.Layout')
@section('content')
<?php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    
    $idUser = Auth::user()->id;
    $role = DB::table('users')->select('role', 'id')->where('id', $idUser)->first();
    $roleAccount = $role->role;
    ?>
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.service') }}">Quản lý dịch vụ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
<div class="container-fluid border border-primary rounded mb-3">
    @foreach ($service as $row)
    <form style="font-size:2vw;font-size:2vh" method="post"
        action="{{ route('admin.updateService', ['id' => $row->id]) }}" class="p-4" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input hidden value="{{ $row->id }}" id="IdServiceHidden">
        <div class="name">
            <label class="form-label"><b>Tên dịch vụ </b> </label>
            <input style="font-size:2vw;font-size:2vh" class="form-control" type="text" name="name"
                value="{{ $row->name }}">
        </div>
        <div class="mt-4">
            <label class="form-label"><b>Mô tả </b> </label>
            <br>
            <img class="mt-2 mb-2 img-fluid" src="{{ asset('assets/img-dichvu/' . $row->image) }}">
            <input style="font-size:2vw;font-size:2vh" class="form-control" type="file" name="hinhanh">
        </div>

        <button type="submit" style="font-size:2vw;font-size:2vh" class="btn btn-success mt-2">Xác nhận</button>
    </form>
    @endforeach
    {{-- danh sách các dịch vụ con --}}
    <div class="mb-2">
        <form id="formAddChildService" method="POST">
            @csrf
            <div class="d-flex justify-content-between">
                <p>Gói dịch vụ</p>
                <input class=" ms-2 form-control w-50" placeholder="Nhập tên dịch vụ ..." style="border:1px solid black"
                    name="childService" id="NamechildService" type="text">
                <input class=" ms-2 form-control w-25" placeholder="Nhập giá dịch vụ ..." style="border:1px solid black"
                    name="childService" id="CostchildService" type="text">
                <select name="TypePetchildService" id="TypePetchildService" class="form-select w-25 ms-1"
                    style="border:1px solid black">
                    <option selected>Chó</option>
                    <option>Mèo</option>
                    <option>Khác</option>
                </select>
                <button class="btn btn-success ms-3" type="submit">Thêm</button>
            </div>

        </form>
    </div>
    <div>
        <table style="font-size:2vw;font-size:2vh" class="table table-hover table-bordered text-center table-responsive"
            cellpadding="0" cellspacing="0" border="0" id="tableChildService">
            <thead>
                <tr class="table-primary">
                    <th>
                        ID gói
                    </th>
                    <th>
                        Tên gói
                    </th>
                    <th>
                        Giá
                    </th>
                    <th>
                        Loại Pet
                    </th>
                    @if ($roleAccount === 'admin')
                    <th>
                        Tính năng
                    </th>
                    @endif

                </tr>
            </thead>
            <tbody id="body-table-childService">
                @foreach ($childService as $row)
                <tr>
                    <td>
                        {{ $row->id }}
                    </td>
                    <td>{{ $row->name }}</td>
                    <td>
                        {{ number_format($row->cost) }} đ
                    </td>
                    <td>
                        {{ $row->type_pet }}
                    </td>
                    @if ($roleAccount === 'admin')
                    <td class="table-td-center">
                        <a> <button onclick="deleteFetch('{{ $row->id }}')" style="font-size:2vw;font-size:2vh"
                                class="btn btn-danger btn-sm trash" type="button" title="Xóa">
                                <i class="fas fa-trash-alt"></i>
                            </button></a>
                        <button
                            onclick="showDetailChildService('{{ $row->name }}','{{ $row->cost }}','{{ $row->id }}','{{ $row->type_pet }}')"
                            style="font-size:2vw;font-size:2vh" data-bs-toggle="modal" data-bs-target="#update-child"
                            class="btn btn-success btn-sm edit" type="button" title="Sửa" id="show-emp">Sửa
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
                {{-- modal cập nhật thông tin gói dịch vụ --}}
                <div class="modal fade" id="update-child" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    Cập nhật thông tin
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="FormUpdateChildService" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="d-flex flex-column">
                                        <input hidden value="" id="IdChildServiceHidden">
                                        <div class="d-flex">
                                            <h6>Tên gói: </h6>
                                            <input class=" ms-2 mb-3 form-control w-60"
                                                placeholder="Nhập tên dịch vụ ..." style="border:1px solid black"
                                                name="childServiceModal" id="NamechildServiceModal" type="text">
                                        </div>
                                        <div class="d-flex">
                                            <h6>Giá </h6>
                                            <input class="ms-4 mb-3 form-control " placeholder="Nhập giá dịch vụ ..."
                                                style="border:1px solid black" name="childServiceModal"
                                                id="CostchildServiceModal" type="text">
                                        </div>
                                        <p class="align-items-start">Loại thú cưng</p>
                                        <select name="TypePetchildServiceModal" id="TypePetchildServiceModal"
                                            class="form-select w-25" style="border:1px solid black">
                                            <option selected>Chó</option>
                                            <option>Mèo</option>
                                            <option>Khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                @for ($i = 1; $i <= $totalPageChildService; $i++) @if ($i===1) <li class="page-item active"><button
                        data-page="{{ $i }}" class="page-link" style="pointer:cursor">{{ $i }}</button></li>
                    @else
                    <li class="page-item"><button data-page="{{ $i }}" class="page-link" style="pointer:cursor">{{ $i
                            }}</button></li>
                    @endif
                    @endfor
            </ul>
        </nav>
    </div>
</div>
<script>
    $(document).ready(function() {
            // thêm các gói dịch vụ
            $("#formAddChildService").submit(function(event) {
                event.preventDefault();
                if ($("#NamechildService").val() !== null && $("#NamechildService").val() !== "" && $(
                        "#CostchildService").val() !== null && $("#CostchildService").val() !== "" && $(
                        "#CostchildService").val() % 1 === 0) {
                    var id = $("#IdServiceHidden").val();
                    var urlFetch = "/admin/services/child/add/" + id;
                    var nameService = $("#NamechildService").val();
                    var CostService = parseInt($("#CostchildService").val());
                    var type_pet = $('#TypePetchildService').val();
                    var nameServiceChild =
                        $.ajax({
                            url: urlFetch,
                            type: "POST",
                            data: {
                                idService: id,
                                nameService: nameService,
                                cost: CostService,
                                type: type_pet,
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(res) {
                                if (res !== 'false') {
                                    var ListChildService = $('#body-table-childService')
                                    ListChildService.append(`
                                    <tr>
                                        <td>
                                            ${ res.id }
                                        </td>
                                        <td>${ res.name }</td>
                                        <td>
                                            ${ res.cost.toLocaleString('vi-VN') } đ
                                        </td>
                                        <td>${ res.type_pet }</td>
                                        @if ($roleAccount === 'admin')
                                        <td class="table-td-center">
                                            <a> <button style="font-size:2vw;font-size:2vh" class="btn btn-danger btn-sm trash" type="button" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button></a>
                                            <button onclick="showDetailChildService('${ res.name }','${ res.cost }','${ res.id }','${res.type_pet}')"
                                                style="font-size:2vw;font-size:2vh" data-bs-toggle="modal" data-bs-target="#update-child"
                                                class="btn btn-success btn-sm edit" type="button" title="Sửa" id="show-emp">Sửa
                                            </button>
                                            {{-- modal cập nhật thông tin gói dịch vụ --}}
                                            <!-- Modal xóa -->
                                            <div class="modal fade" id="update-child" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                Cập nhật thông tin
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                  <form id="FormUpdateChildService" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="d-flex flex-column">
                                                                <input hidden value="" id="IdChildServiceHidden">
                                                                <div class="d-flex">
                                                                    <h6>Tên gói: </h6>
                                                                    <input class=" ms-2 mb-3 form-control w-60" placeholder="Nhập tên dịch vụ ..."
                                                                        style="border:1px solid black" name="childServiceModal" id="NamechildServiceModal" type="text">
                                                                </div>
                                                                <div class="d-flex">
                                                                    <h6>Giá </h6>
                                                                    <input class="ms-4 mb-3 form-control " placeholder="Nhập giá dịch vụ ..." style="border:1px solid black"
                                                                        name="childServiceModal" id="CostchildServiceModal" type="text">
                                                                </div>
                                                                <p class="align-items-start">Loại thú cưng</p>
                                                                <select name="TypePetchildServiceModal" id="TypePetchildServiceModal" class="form-select w-25"
                                                                    style="border:1px solid black">
                                                                    <option selected>Chó</option>
                                                                    <option>Mèo</option>
                                                                    <option>Khác</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    `)
                                    $.toast({
                                        heading: 'Thông báo',
                                        text: 'Thêm gói dịch vụ thành công',
                                        showHideTransition: 'slide',
                                        icon: 'success',
                                        position: 'bottom-right'
                                    })
                                } else {
                                    $.toast({
                                        heading: 'Thông báo',
                                        text: 'Có lỗi xảy ra !',
                                        showHideTransition: 'slide',
                                        icon: 'error',
                                        position: 'bottom-right'
                                    })
                                }
                            },
                            error: function(e) {
                                console.log(e)
                            }
                        })
                } else {
                    alert("Vui lòng kiểm tra lại thông tin !")
                }
            })
        })
        // xóa gói dịch vụ
        function deleteFetch(id) {
            if (confirm("Bạn có muốn xóa gói dịch vụ này không")) {
                var urlFetch = "/admin/services/child/delete/" + id;
                var nameServiceChild =
                    $.ajax({
                        url: urlFetch,
                        type: "DELETE",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(res) {
                            if (res !== 'false') {
                                $("#body-table-childService tr").each(function() {
                                    var rowId = $(this).find("td:first").text()
                                        .trim(); // Lấy ID từ cột đầu tiên
                                    if (rowId == id) {
                                        $(this).remove(); // Xóa dòng có ID trùng
                                    }
                                });
                                $.toast({
                                    heading: 'Thông báo',
                                    text: 'Xóa thành công !',
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right'
                                })
                            } else {
                                $.toast({
                                    heading: 'Thông báo',
                                    text: 'Có lỗi xảy ra !',
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    position: 'bottom-right'
                                })
                            }
                        },
                        error: function(e) {
                            console.log(e)
                        }
                    })

            }
        }
        // hiển thị modal dịch vụ
        function showDetailChildService(name, cost, id, type) {
            $("#NamechildServiceModal").val(name)
            $("#CostchildServiceModal").val(cost)
            $("#IdChildServiceHidden").val(id)
            $("#TypePetchildServiceModal").val(type)
        }
        // var name = $("#NamechildServiceModal").val()
        // var cost = $("#CostchildServiceModal").val()
        // var type = $("#TypePetchildServiceModal").val()

        // cập nhật lại dịch vụ
        $('#FormUpdateChildService').submit(function(event) {
            event.preventDefault();
            if ($("#NamechildServiceModal").val() !== null && $("#NamechildServiceModal").val() !== "" && $(
                    "#CostchildServiceModal").val() !== null && $("#CostchildServiceModal").val() !== "" && $(
                    "#CostchildServiceModal").val() % 1 === 0) {
                var id = $("#IdChildServiceHidden").val();
                var urlFetch = "/admin/services/child/update";
                var nameService = $("#NamechildServiceModal").val();
                var CostService = parseInt($("#CostchildServiceModal").val());
                var typePet = $("#TypePetchildServiceModal").val()
                var nameServiceChild =
                    $.ajax({
                        url: urlFetch,
                        type: "POST",
                        data: {
                            idService: id,
                            nameService: nameService,
                            cost: CostService,
                            type: typePet,
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(res) {
                            if (res !== 'false') {
                                $("#NamechildServiceModal").val(nameService)
                                $("#CostchildServiceModal").val(CostService)
                                $("#TypePetchildServiceModal").val(typePet)
                                // Tìm hàng có ID trùng và cập nhật lại dữ liệu
                                $("#body-table-childService tr").each(function() {
                                    var rowId = $(this).find("td:first").text()
                                        .trim(); // Lấy ID từ cột đầu tiên

                                    if (rowId == id) {
                                        $(this).find("td:eq(1)").text(
                                            nameService); // Cập nhật cột tên dịch vụ
                                        $(this).find("td:eq(2)").text(res.cost.toLocaleString(
                                                'vi-VN') +
                                            " đ"); // Cập nhật cột giá
                                        $(this).find("td:eq(3)").text(
                                            typePet); // Cập nhật cột type pet
                                    }
                                });
                                $.toast({
                                    heading: 'Thông báo',
                                    text: 'Cập nhật thành công !',
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right'
                                })
                            } else {
                                $.toast({
                                    heading: 'Thông báo',
                                    text: 'Có lỗi xảy ra !',
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    position: 'bottom-right'
                                })
                            }
                        },
                        error: function(e) {
                            console.log(e)
                        }
                    })
            } else {
                alert("Vui lòng kiểm tra lại thông tin !")
            }
        })
        $(document).on("click", ".pagination .page-link", function(event) {
            event.preventDefault(); // Ngăn reload trang
            $(".pagination .page-item").removeClass("active"); // Xóa active từ tất cả các trang
            $(this).parent().addClass("active"); // Thêm active vào trang được chọn
            // lấy trang active 
            var page = $(this).data('page');
            // lấy dữ liệu từ page và load lại bảng
            var id = $("#IdServiceHidden").val();
            var urlFetchByPage = "/admin/services/child/getPage/" + id + "?page=" + page;
            $.ajax({
                url: urlFetchByPage,
                type: "GET",
                success: function(response) {
                    $("#body-table-childService tr").empty()
                    $("#body-table-childService").append(`{{-- modal cập nhật thông tin gói dịch vụ --}}
                    <div class="modal fade" id="update-child" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        Cập nhật thông tin
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="FormUpdateChildService" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="d-flex flex-column">
                                            <input hidden value="" id="IdChildServiceHidden">
                                            <div class="d-flex">
                                                <h6>Tên gói: </h6>
                                                <input class=" ms-2 mb-3 form-control w-60" placeholder="Nhập tên dịch vụ ..."
                                                    style="border:1px solid black" name="childServiceModal" id="NamechildServiceModal"
                                                    type="text">
                                            </div>
                                            <div class="d-flex">
                                                <h6>Giá </h6>
                                                <input class="ms-4 mb-3 form-control " placeholder="Nhập giá dịch vụ ..."
                                                    style="border:1px solid black" name="childServiceModal" id="CostchildServiceModal"
                                                    type="text">
                                            </div>
                                            <p class="align-items-start">Loại thú cưng</p>
                                            <select name="TypePetchildServiceModal" id="TypePetchildServiceModal" class="form-select w-25"
                                                style="border:1px solid black">
                                                <option selected>Chó</option>
                                                <option>Mèo</option>
                                                <option>Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>`)
                    response.data.forEach(res => {
                        $("#body-table-childService").append(`
                    <tr>
                        <td>
                            ${ res.id }
                        </td>
                        <td>${ res.name }</td>
                        <td>
                            ${ res.cost.toLocaleString('vi-VN') } đ
                        </td>
                        <td>${ res.type_pet }</td>
                        @if ($roleAccount === 'admin')
                        <td class="table-td-center">
                            <a> <button onclick="deleteFetch('${res.id}')" style="font-size:2vw;font-size:2vh" class="btn btn-danger btn-sm trash" type="button" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </button></a>
                            <button onclick="showDetailChildService('${ res.name }','${ res.cost }','${ res.id }','${res.type_pet}')"
                                style="font-size:2vw;font-size:2vh" data-bs-toggle="modal" data-bs-target="#update-child"
                                class="btn btn-success btn-sm edit" type="button" title="Sửa" id="show-emp">Sửa
                            </button>
                        </td>
                        @endif
                    </tr>
                    `)
                    });

                },
                error: function(e) {
                    console.log(e)
                }
            })
        });
</script>
@endsection