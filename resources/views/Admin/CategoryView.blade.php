@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <h1 style="font-size:2.5vw;font-size:2.5vh">Quản lý danh mục</h1>
    <!-- End Page Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="button-function d-flex justify-content-between mt-3 mb-4" style="width:70%">

                        <button style="font-size:2vw;font-size:2vh" id="uploadfile" class="btn btn-success"
                            type="button" title="Nhập"><a id="addnhanvien" href="{{ route('admin.categoryForm') }}"
                                data-bs-target="#modalCreate" data-bs-toggle="modal"><i class="fas fa-plus"></i>>
                                Tạo mới danh mục</a></button>
                        <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo mới
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="formCreateCategory">
                                        <div class="modal-body">
                                            <label for="nameCategory">Tên danh mục</label>
                                            <input class="form-control" style="border:1px solid black"
                                                name="nameCategory" id="nameCategory" type="text">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tạo</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search mt-4 mb-4 input-group" style="width:50%">
                        <button style="font-size:2vw;font-size:2vh" class="input-group-text btn btn-success"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="form-control" type="text" id="searchNV">
                    </div>
                    <table style="font-size:2vw;font-size:2vh" class="table table-hover table-bordered text-center"
                        cellpadding="0" cellspacing="0" border="0" id="sampleTable">
                        <thead>
                            <tr class="table-primary">
                                <th>
                                    ID danh mục
                                </th>
                                <th>
                                    Tên danh mục
                                </th>
                                <th>
                                    Tính năng
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table-category">
                            @foreach ($category as $row)
                            <tr>
                                <td>{{ $row->idCat }}</td>
                                <td>{{ $row->name }}</td>
                                {{-- @if ($roleAccount === 'admin') --}}
                                <td class="table-td-center">
                                    <button style="font-size:2vw;font-size:2vh"
                                        class="btn btn-danger btn-sm trash buttonDeleteCategory"
                                        data-id="{{ $row->idCat }}" type="button">
                                        <a style="color:white"> <i class="fas fa-trash-alt"></i></a>
                                    </button>

                                    {{-- button sửa danh mục --}}
                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-sm edit"
                                        type="button" title="Sửa" id="show-emp" data-bs-toggle="modal"
                                        data-bs-target="#update{{ $row->idCat }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Modal sửa danh mục -->
                                    <div class="modal fade" id="update{{ $row->idCat }}" tabindex="-1"
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
                                                <div class="modal-body">
                                                    <p>Tên danh mục</p>
                                                    <input style="font-size:2vw;font-size:2vh" class="form-control"
                                                        type='text' name='nameCat' id="nameCatUpdate{{ $row->idCat }}"
                                                        value="{{ $row->name }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button style="font-size:2vw;font-size:2vh" type="button"
                                                        class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    <button style="font-size:2vw;font-size:2vh"
                                                        class="btn btn-primary buttonUpdateCategory"
                                                        data-id="{{ $row->idCat }}"><a
                                                            style="text-decoration:none;color:white">Đồng
                                                            ý</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{-- @endif --}}

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{ $category->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@vite('resources/js/Admin/category/create.js')
@vite('resources/js/Admin/category/delete.js')
@vite('resources/js/Admin/category/update.js')
@endsection