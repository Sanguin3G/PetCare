@extends('User.LayoutTrangChu')

@section('content')
<!-- main images -->
<style>
    .MenuCat {
        flex: 1;
    }

    .ProList {
        flex: 3;
    }
</style>
<?php use Illuminate\Support\Str; ?>
<div class="productViewUser" style="min-height: 900px">
    <!-- Danh mục sản phẩm-->
    <div class="container-fluid">
        <div class="SmallCategory">
            <div class="dropdown mb-2">
                <a class="btn btn-info dropdown-toggle" role="button" data-bs-toggle="dropdown">
                    Danh mục
                </a>
                <ul class="dropdown-menu">
                    @foreach ($category as $row)
                    <li><button type="button" class="dropdown-item button-category-item-small">{{ $row->name
                            }}</button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="d-flex">
            <div class="MenuCat">
                {{-- <a href="{{ route('user.destroyCart') }}">click</a> --}}
                <h3 class="text-center mb-2" style="font-size:2vh 2vw">Danh mục sản phẩm</h3>
                <ul class="category list-group">
                    <!-- Lấy dữ liệu bảng danh mục xuất ra danh mục -->
                    <input hidden id="FirstIdCatHidden" value="{{ $category[0]->idCat }}">
                    @foreach ($category as $row)
                    <li class="list-group-item">
                        <button class="btn btn-white button-category-item" data-id="{{ $row->idCat }}"
                            style="width:100%">
                            {{ $row->name }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="ProList ms-3">
                <nav class="navbar mb-3 navbar-light bg-light justify-content-between">
                    {{-- <h3 style="color:black">
                        @foreach ($categoryName as $name)
                        {{ $name->name }}
                        <p class="hiddenCat" hidden>{{ $name->idCat }}</p>
                        @endforeach
                    </h3> --}}
                    {{-- button tìm kiếm --}}
                    <form class="form-inline d-flex me-3">
                        <input class="form-control mr-sm-2" type="text" id="nameProductSearch" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 ml-3" id="buttonSearch" type="button"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </nav>
                {{-- Danh sách sản phẩm --}}
                <div>

                </div>
                <div>
                    <div class="dropdown" style="font-size:1.3vw 1.3vh">
                        <button class="btn btn-white dropdown-toggle" style="border:1px solid black" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Sắp xếp
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="sort-button btn btn-white" data-field="cost" data-order="asc">Giá tăng từ
                                    thấp ->
                                    cao</button></li>
                            <li><button class="sort-button btn btn-white" data-field="cost" data-order="desc">Giá từ cao
                                    ->
                                    thấp</button></li>
                            <li><button class="sort-button btn btn-white" data-field="namePro" data-order="asc">Sắp xếp
                                    từ A ->
                                    Z</button></li>
                            <li><button class="sort-button btn btn-white" data-field="namePro" data-order="desc">Sắp xếp
                                    từ Z ->
                                    A</button></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <div class="product-list d-flex flex-wrap">
                        <!-- Lấy dữ liệu từ bảng product để xuất ra sản phẩm -->
                        @foreach ($products as $product)
                        {{-- Thông tin sản phẩm --}}
                        <div id="product-infor" class="card position-relative" style="max-width:15rem;height:27rem"
                            style="border:0px">
                            {{-- giảm giá sản phẩm --}}
                            @if ($product->discount > 0)
                            <div class="onsale position-absolute top-0 start-0">
                                <span class="badge rounded-0 bg-danger"><i class="fa-solid fa-arrow-down"></i>
                                    {{ $product->discount }}%
                                </span>
                            </div>
                            @endif
                            <div>
                                {{-- hình ảnh sản phẩm --}}
                                <?php
                                        $nameProduct = Str::slug($product->namePro); ?>
                                <a id="img_pro"
                                    href="{{ route('user.productDetail', ['id' => $product->idPro, 'name' => $nameProduct]) }}">
                                    <img class="card-img-top img-fluid p-2" style="max-height:20rem"
                                        src="{{ asset('assets/img-add-pro/' . $product->getImgProduct($product->idPro)) }}"
                                        alt="Card image cap"></a>
                            </div>
                            <div class="card-body" id="card-body">
                                <h6 id="name-product" class="card-title">
                                    {{ $product->namePro }}

                                </h6>
                                <span class="rating secondary-font">
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <i class="fa-solid fa-star text-warning"></i>
                                    5.0</span>
                                @if ($product->discount <= 0) <p class="card-text text-danger">
                                    {{ number_format($product->cost) }}đ
                                    </p>

                                    <p hidden id="productCostHidden">{{ $product->cost }}</p>
                                    @else
                                    <p class="card-text text-danger text-decoration-line-through">
                                        {{ number_format($product->cost) }}đ
                                    </p>
                                    <p class="card-text text-danger" style="margin-top:-15px">

                                        {{ number_format($product->cost - ($product->cost * $product->discount) / 100)
                                        }}đ
                                    </p>
                                    <p hidden id="productCostHidden">
                                        {{ $product->cost - ($product->cost * $product->discount) / 100 }}
                                    </p>
                                    @endif
                                    {{-- <a href="{{ route('user.add', ['id' => $product->idPro]) }}"
                                        style="text-decoration:none;color:white"><button type="submit"
                                            style="position:absolute;top:0;right:0"
                                            class="btn btn-white shadow-sm rounded-pill"><i style="color:black"
                                                class="fa-solid fa-cart-shopping text-danger"></i></button></a> --}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalbuyproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Đã thêm sản phẩm vào giỏ hàng !
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End mục sản phẩm-->
<!-- Tìm kiếm sản phẩm -->
@vite('resources/js/User/product/get.js')
@endsection