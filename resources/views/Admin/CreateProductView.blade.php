@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Quản lý sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li>
        </ol>
    </nav>
    <div style="background-color: white;padding:20px;border-radius:20px;box-shadow: 2px 2px 2px #FFCC99;">
        <!-- End Page Title -->
        <form style="font-size:2vw;font-size:2vh" method="post" id="AddProForm" enctype="multipart/form-data"
            class="row mt-4">
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Tên sản phẩm</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" id="namepro" name="namepro" type="text"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Số lượng</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" name="countpro" id="countpro"
                    type="text" required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Giá bán(VND)</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" id="giabanpro" name="giabanpro"
                    type="text" required>
            </div>
            <div class="form-group  col-md-4">
                <label style="font-weight: bolder;" class="control-label mt-3">Giảm giá(%)</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" id="giavonpro" name="discount"
                    type="text">
            </div>

            <div class="form-group col-md-3">
                <label style="font-weight: bolder;" class="control-label mt-3">Danh mục</label>
                <select style="font-size:2vw;font-size:2vh" class="form-control" id="danhmucAddpro" required
                    name="danhmucAddpro" required>
                    <option>Chọn danh mục</option>
                    @if ($category)
                    @foreach ($category as $row )
                    <option value="{{ $row->idCat }}">{{ $row->name }}</option>
                    @endforeach
                    @endif

                </select>
            </div>
            <div class="form-group ">
                <label style="font-weight: bolder;" class="control-label mt-3">Mô tả sản phẩm</label>
                <textarea style="font-size:2vw;font-size:2vh" id="mota" name="mota" class="form-control"> </textarea>
                <script type="text/javascript">
                    CKEDITOR.replace("mota");
                </script>
            </div>
            <div class="form-group col-md-12">
                <label style="font-weight: bolder;" class="control-label mt-3">Ảnh sản phẩm</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" multiple id="imagepro" name="imagepro[]"
                    style="width:30%" type="file">
            </div>
            <div class="image-preview">
                {{-- <div class="preview-container">
                    <div class="preview-image">
                        <img src="" alt="Ảnh đã chọn" class="preview-image" />
                        <button class="remove-btn" type="button">❌</button>
                    </div>
                </div> --}}
            </div>
            <button class="btn btn-success mt-4 ms-2" type="submit" id="buttonAddPro"
                style="width:10%;font-size:2vw;font-size:2vh" value="Thêm" name="addproduct"> Thêm
            </button>
        </form>

    </div>
</div>
@vite('resources/js/Admin/product/CreateProduct.js')
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/translations/vi.js"> </script>
<script src="{{ asset('assets/js/admin/addproduct.js') }}"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
        max-height: 450px;
    }

    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .preview-container {
        position: relative;
        width: 120px;
        height: 120px;
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Nút X để xóa ảnh */
    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        font-size: 14px;
    }
</style>
<script>
    ClassicEditor.create(document.querySelector('#mota'), {
            language: 'vi'
        })
        .then(editor => {})
        .catch(error => {
            console.error(error)
        });
</script>
@endsection