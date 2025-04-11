@extends('Admin.Layout')
@section('content')
    <div class="pagetitle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-size: 22px;">
                <li class="breadcrumb-item">Quản lý dịch vụ</li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết dịch vụ</li>
            </ol>
        </nav>
        <!-- End Page Title -->
        <form method="post" class="row mt-4" id="AddServiceForm" enctype="multipart/form-data"
            style="background-color: white;padding:20px;border-radius:20px;box-shadow: 2px 2px 2px #FFCC99;">
            <div class="form-group ">
                <label style="font-weight: bolder;" class="control-label">Tên dịch vụ</label>
                <input class="form-control" id="nameDM" value="{{ $service->name }}" name="nameDM" style="max-width:50%"
                    type="text">
            </div>
            <br>
            <div class="form-group mt-3">
                <label style="font-weight: bolder;" class="control-label">Ảnh dịch vụ</label>
                <div class="preview-container">
                    <div class="preview-image">
                        <img src="{{ asset('assets/img-dichvu/' . $service->image) }}" alt="Ảnh đã chọn"
                            class="preview-image" />
                        {{-- <button class="remove-btn" type="button">❌</button> --}}
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <input class="form-control mt-2" id="imageService" name="imageService" style="max-width:30%" type="file">
            </div>
            <div class="image-preview mt-4">

            </div>
            <button class="btn btn-success mt-3" type="submit" id="addbutton" style="width:10%">Cập nhật</button>
        </form>
    </div>
    @vite('resources/js/Admin/Service/create.js')
@endsection
<style>
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
        width: 100%;
        height: 100%;
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
