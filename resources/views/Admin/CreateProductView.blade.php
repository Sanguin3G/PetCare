@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="">
            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Quản lý sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li>
        </ol>
    </nav>
    <div class="admin-form-surface p-4">
        <h1>Thêm sản phẩm</h1><p class="text-muted">Thông tin, tồn kho và hình ảnh cho cửa hàng PetCare.</p>
        <!-- End Page Title -->
        <form style="" method="post" id="AddProForm" enctype="multipart/form-data"
            class="row mt-4">
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label" for="namepro">Tên sản phẩm</label>
                <input style="" class="form-control" id="namepro" name="namepro" type="text"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label" for="countpro">Số lượng</label>
                <input style="" class="form-control" name="countpro" id="countpro"
                    type="number" min="0" step="1" required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label" for="giabanpro">Giá bán(VND)</label>
                <input style="" class="form-control" id="giabanpro" name="giabanpro"
                    type="number" min="0" step="1" required>
            </div>
            <div class="form-group  col-md-4">
                <label style="font-weight: bolder;" class="control-label mt-3" for="giavonpro">Giảm giá(%)</label>
                <input style="" class="form-control" id="giavonpro" name="discount"
                    type="number" min="0" max="100" step="1">
            </div>

            <div class="form-group col-md-3">
                <label style="font-weight: bolder;" class="control-label mt-3" for="danhmucAddpro">Danh mục</label>
                <select style="" class="form-control" id="danhmucAddpro" required
                    name="danhmucAddpro">
                    <option>Chọn danh mục</option>
                    @if ($category)
                    @foreach ($category as $row )
                    <option value="{{ $row->idCat }}">{{ $row->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group ">
                <label style="font-weight: bolder;" class="control-label mt-3" for="mota">Mô tả sản phẩm</label>
                <textarea style="" id="mota" name="mota" class="form-control"> </textarea>

            </div>
            <div class="form-group col-md-12">
                <label style="font-weight: bolder;" class="control-label mt-3" for="imagepro">Ảnh sản phẩm</label>
                <input style="" class="form-control" multiple id="imagepro" name="imagepro[]"
                    accept="image/jpeg,image/png,image/gif,image/webp" required type="file">
            </div>
            <div class="image-preview">
            </div>
            <button class="btn btn-success mt-4 ms-2" type="submit" id="buttonAddPro"
                 value="Thêm" name="addproduct"> Thêm
            </button>
        </form>

    </div>
</div>
@vite('resources/js/Admin/product/CreateProduct.js')
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>




@endsection
