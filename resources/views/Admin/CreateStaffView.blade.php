@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
      <li class="breadcrumb-item"><a href="{{ route('admin.staff') }}">Quản lý nhân viên</a></li>
      <li class="breadcrumb-item active" aria-current="page">Chi tiết nhân viên</li>
    </ol>
  </nav>
  <!-- End Page Title -->
  <form style="font-size:2vw;font-size:2vh" id="FormCreateStaff" class="row mt-4" method="post"
    enctype="multipart/form-data"
    style="background-color: white;padding:20px;border-radius:20px;box-shadow: 2px 2px 2px #FFCC99;">
    <div class="form-group col-md-4">
      <label style="font-weight: bolder;" class="control-label">Họ và tên</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" id="nameNV" name="nameNV" type="text" required>
      <small class="text-danger error-name d-none">Họ tên không được chứa số hoặc ký tự đặc biệt</small>
    </div>
    <div class="form-group col-md-4">
      <label style="font-weight: bolder;" class="control-label">Địa chỉ email</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" id="emailNV" name="emailNV" type="text" required>
      <small class="text-danger error-email d-none">Email không đúng định dạng</small>
    </div>
    <div class="form-group col-md-4">
      <label style="font-weight: bolder;" class="control-label">Địa chỉ thường trú</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" id="localNV" name="localNV" type="text" required>
    </div>
    <div class="form-group  col-md-4">
      <label style="font-weight: bolder;" class="control-label mt-3">Số điện thoại</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" id="phoneNV" name="phoneNV" type="text" required>
      <small class="text-danger error-phone d-none">Vui lòng nhập số điện thoại hợp lệ</small>
    </div>

    <div class="form-group  col-md-3">
      <label style="font-weight: bolder;" style="font-weight: bolder;" class="control-label mt-3">Ngày tháng năm
        sinh</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" id="dateNV" name="dateNV" type="date" required>
    </div>
    <div class="form-group col-md-3">
      <label style="font-weight: bolder;" class="control-label mt-3">Số CMND/CCCD</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" name="CMND" id="CMND" type="text" required>
      <small class="text-danger error-cccd d-none">Vui lòng nhập đúng định dạng CMND/CCCD</small>
    </div>

    <div class="form-group col-md-3">
      <label style="font-weight: bolder;" class="control-label mt-3">Giới tính</label>
      <select style="font-size:2vw;font-size:2vh" class="form-control" name="sex" id="sex" id="exampleSelect2" required>
        <option>Chọn giới tính</option>
        <option>Nam</option>
        <option>Nữ</option>
        <option>Khác</option>
      </select>
    </div>

    <div class="form-group  col-md-3">
      <label style="font-weight: bolder;" class="control-label mt-3">Chức vụ</label>
      <input style="font-size:2vw;font-size:2vh" class="form-control" name="chucvu" required>
    </div>


    <div class="form-group col-md-12">
      <label style="font-weight: bolder;" class="control-label mt-3">Ảnh 3x4 nhân viên</label>
      <input style="font-size:2vw;font-size:2vh;width:20%" class="form-control" type="file" id="uploadImgNV"
        name="imgNV" required>
      <small class="text-danger d-none error-image">Vui lòng nhập đúng định dạng file ảnh</small>
      <div style="position:relative" class="image-preview d-none">
        <img src="{{ asset('assets/img/PetCARE.png') }}" style="max-width:400px;max-height:400px;margin-top:20px">
        <button id="removeImage" type="button"
          style="width:30px;height:30px;position: absolute;background:red;color:white;border-radius:5px">X</button>
      </div>
    </div>
    <a style="text-decoration:none;color:white"> <button class="btn btn-success mt-4" type="submit" id="addbutton"
        style="width:10%;font-size:2vw;font-size:2vh">Thêm</button></a>
  </form>
</div>
@vite('resources/js/Admin/staff/CreateStaff.js')
@endsection