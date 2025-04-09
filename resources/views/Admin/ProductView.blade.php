@extends('Admin.Layout')
@section('content')
    <div class="pagetitle">
        <h1 style="font-size:2.5vw;font-size:2.5vh">Quản lý sản phẩm</h1>
        <!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="button-function d-flex justify-content-between mt-3 mb-4" style="width:70%">

                            <button style="font-size:2vw;font-size:2vh" id="uploadfile"
                                class="btn btn-success btn-sm nhap-tu-file" type="button" title="Nhập"><a
                                    style="color:white" href="{{ route('admin.addForm') }}"><i class="fas fa-plus"></i>>
                                    Tạo mới sản phẩm</a></button>
                        </div>
                        <div class="search mt-4 mb-4 input-group" style="width:50%">
                            <button style="font-size:2vw;font-size:2vh" class="input-group-text btn btn-success"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                            <input class="form-control" type="text" id="searchProduct">
                        </div>
                        <div class="table-responsive">
                            <table style="font-size:2vw;font-size:2vh" class="table table-hover table-bordered "
                                id="sampleTable">
                                <thead>
                                    <tr class="table-success text-center">
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Ảnh</th>
                                        <th>Số lượng</th>
                                        <th>Tình trạng</th>
                                        <th>Giá tiền</th>
                                        <th>Giảm giá</th>
                                        <th>Hot</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody id="table-product">
                                    @foreach ($product as $row)
                                        <tr class="text-center">
                                            <td>{{ $row->idPro }}</td>
                                            <td>{{ $row->namePro }}</td>
                                            @if ($row->ImageProduct->isNotEmpty())
                                                <td class="text-center"><img
                                                        src="{{ asset('assets/img-add-pro/' . $row->ImageProduct->first()->image) }}"
                                                        style="width:10vw;height:auto"></td>
                                            @else
                                                <td></td>
                                            @endif

                                            <td>{{ $row->count }}</td>

                                            @if ($row->count > 0)
                                                <td><button class="btn btn-success">Còn hàng</button></td>
                                            @else
                                                <td><button class="btn btn-danger">Hết hàng</button></td>
                                            @endif
                                            <td>{{ number_format($row->cost, 0, ',', '.') }} đ</td>
                                            @if ($row->discount > 0)
                                                <td>{{ $row->discount }}%</td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if ($row->hot > 0)
                                                <td><i class="fa-solid fa-check" style="color: #06e302;"></i></td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td class="table-td-center">
                                                <button style="font-size:2vw;font-size:2vh"
                                                    class="btn btn-danger btn-sm trash button-delete-product"
                                                    data-id="{{ $row->idPro }}" type="button" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button style="font-size:2vw;font-size:2vh"
                                                    class="btn btn-success btn-sm edit" type="button" title="Sửa"
                                                    id="show-emp">
                                                    <?php
                                                    $nameProduct = Str::slug($row->namePro);
                                                    ?>
                                                    <a style="text-decoration:none;color:white"
                                                        href="{{ route('admin.changeProductView', ['id' => $row->idPro, 'name' => $nameProduct]) }}"><i
                                                            class="fas fa-edit"></i> </a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        @for ($i = 1; $i <= $last_page; $i++)
                            @if ($i == 1)
                                <li class="page-item active"><button class="page-link page-link-product"
                                        data-page="{{ $i }}">{{ $i }}</button>
                                </li>
                            @else
                                <li class="page-item"><button class="page-link page-link-product"
                                        data-page="{{ $i }}">{{ $i }}</button>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="loading-overlay d-none">
            <div class="spinner"></div>
        </div>
    </div>
    @vite('resources/js/admin/product/delete.js')
    @vite('resources/js/admin/product/get.js')
@endsection
