@extends('User.LayoutTrangChu')
@section('content')
<!-- main images -->
@if (session('notice'))
<script>
  $.toast({
                heading: 'Success',
                text: '{{ session('notice') }}',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'bottom-right'
            })
</script>
@endif
@if (session('error'))
<script>
  $.toast({
                heading: 'Error',
                text: '{{ session('error') }}',
                showHideTransition: 'slide',
                icon: 'error',
                position: 'bottom-right'
            })
</script>
@endif
<style>
  .gif {
    flex: 1;
  }

  .formBooking {
    flex: 2;
  }
</style>
<!-- Booking -->
<div class=" bookingUserView">
  <h3 class="service text-capitalize" style="font-size:3vw;font-size:3vh">ĐẶT LỊCH NGAY</h3>
  <hr>
  <div class="d-flex">
    <div class="gif">
      <img src="{{ asset('assets/img/load2.gif') }}" class="img-fluid">

    </div>
    <div class="formBooking align-items-left d-flex justify-content-left ps-5">
      <form style="width:80%;font-size:2vw;font-size:2vh" method="post" class="align-items-center" name=" booking_form"
        id="booking_form">
        @csrf
        @method('post')
        <div class="form-group">
          @if (!Auth('customer')->check())
          <p><a style="text-decoration:none;font-size:2vw;font-size:2vh" href="{{ route('user.login') }}">Vui lòng đăng
              nhập tài khoản để đặt
              lịch</a> </p>
          @endif
          <i class="text-danger" style="font-size:2vw;font-size:2vh">Vui lòng điền đầy đủ thông tin !</i>
          <br>
          <label style="font-size:2vw;font-size:2vh" for="Bossname">Tên của Boss</label>
          <input value="{{ old('name') }}" type="text" style="font-size:2vw;font-size:2vh" class="form-control bossname"
            id="Bossname" name="name" placeholder="Nhập tên của boss" required>

        </div>
        <div class="form-group">
          <label for="Bosstype">Boss là: </label>
          <select onchange="changeTypePet(this.value)" name="type" class="form-select" id="BossType">
            <option value="Chọn loại PET">Chọn loại PET</option>
            <option value="Chó">Chó</option>
            <option value="Mèo">Mèo</option>
            <option value="Khác">Khác</option>
          </select>
        </div>
        <div class="form-group">
          <label for="ServiceName">Tên dịch vụ: </label>
          <select onchange="getListChildService(this.value)" id="ServiceName" name="dichvu" class="form-select">
            @foreach ($listService as $row)
            @if ($id === $row->id)
            <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
            @else
            <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="goi">Tên gói: </label>
          <select class="form-select selectChildService" id="goi" name="goi">
            <option selected value="0" data-price="0">Chọn gói dịch vụ</option>
            @foreach ($listChildService as $row)
            <option value="{{ $row->id }}" data-price="{{ $row->cost }}">{{ $row->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="Bossweight">Cân nặng(kg): </label>
          <input value="{{ old('weight') }}" style="font-size:2vw;font-size:2vh" type="text" class="form-control"
            id="Bossweight" required name="weight" placeholder="Điền cân nặng của Boss">
        </div>
        <div class="Date">
          <p>Chọn lịch</p>
          <input style="font-size:2vw;font-size:2vh" name="date" type="datetime-local" id="dateBook"
            class="form-control" placeholder="Nhập lịch" value="{{ old('date') }}" required type="text">
        </div>
        <div class="form-group">
          <label for="NoteBook">Ghi chú (nếu có): </label>
          <input value="{{ old('note') }}" style="font-size:2vw;font-size:2vh" type="text" class="form-control"
            id="NoteBook" required name="note" style="height:100px">
        </div>
        <br>
        <p>Thành tiền: <span id="totalCost" class="text-danger"></span></p>
        <div class="align-items-center d-flex justify-content-center">
          @if (!Auth('customer')->check())
          <button style="font-size:3vw;font-size:3vh" class="btn btn-danger mt-3 submit_booking mb-2"><a
              style="color:white;text-decoration:none" href="{{ route('user.login') }}">Đặt lịch</a></button>
          @else
          <button style="font-size:3vw;font-size:3vh" type="submit" class="btn btn-danger mt-3 submit_booking mb-2">
            Đặt lịch
          </button>
          @endif

        </div>
      </form>
    </div>
  </div>
</div>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  $(document).ready(function() {
            $("#booking_form").submit(function(event) {
                event.preventDefault();
                // biến kiểm tra trạng thái của form
                var isValid = true;
                $("#booking_form input, #booking_form select").each(function() {
                    if ($(this).val().trim() === "" || $(this).val() === '0') {
                        isValid = false;
                        $(this).addClass("is-invalid"); // Thêm class báo lỗi (nếu có CSS)
                    } else {
                        $(this).removeClass("is-invalid"); // Xóa class lỗi nếu hợp lệ
                    }
                });
                if ($("#BossType").val() === 'Chọn loại PET') {
                    isValid = false
                }
                var UrlFetch = "/book"
                if (isValid === true) {
                    $.ajax({
                        url: UrlFetch,
                        type: 'POST',
                        data: {
                            name: $("#Bossname").val().trim(),
                            type: $("#BossType").val(),
                            name_service: $("#ServiceName").val(),
                            goi: $("#goi").val(),
                            weight: $("#Bossweight").val(),
                            date: $("#dateBook").val(),
                            note: $("#NoteBook").val(),
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.status === 'success') {
                                $.toast({
                                    heading: 'Thông báo',
                                    text: response.message,
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right'
                                })
                                window.location.href = "/order";
                            } else if (response.status === 'success' && response.message ===
                                'Trùng lịch') {
                                $.toast({
                                    heading: 'Thông báo',
                                    text: response.message,
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    position: 'bottom-right'
                                })
                            } else {
                                $.toast({
                                    heading: 'Thông báo',
                                    text: response.message,
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    position: 'bottom-right'
                                })
                            }
                        },
                        error: function(e) {
                            console.log(e)
                            $.toast({
                                heading: 'Thông báo',
                                text: 'Có lỗi xảy ra! Vui lòng thử lại sau',
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right'
                            })
                        }
                    })
                } else {
                    alert("Vui lòng nhập đủ thông tin")
                }
            })
        });

        function changeTypePet(typePet) {
            if (typePet === 'Chọn loại PET' || typePet === 'Khác') {
                typePet = 'all'
            }
            var idService = $("#ServiceName").val().trim()
            var urlFetch = "/service/childs/getAll/" + idService + "/" + typePet
            $.ajax({
                url: urlFetch,
                type: 'GET',
                success: function(e) {
                    console.log(e)
                    $(".selectChildService").empty()
                    e.forEach(row => {
                        $(".selectChildService").append(`
            <option value="${row.id}" data-price="${row.cost}">${row.name}</option>
            `)
                    })

                }
            })
        }

        function getListChildService(idService) {
            var typePet = 'all'
            if ($("#BossType").val() !== 'Chọn loại PET' && $("#BossType").val() !== 'Khác') {
                typePet = $("#BossType").val().trim()
            }
            var urlFetch = "/service/childs/getAll/" + idService + "/" + typePet
            $.ajax({
                url: urlFetch,
                type: 'GET',
                success: function(e) {
                    console.log(e)
                    $(".selectChildService").empty()
                    e.forEach(row => {
                        $(".selectChildService").append(`
                      <option value="${row.id}" data-price="${row.cost}">${row.name}</option>
                      `)
                    })

                }
            })
        }
        // hiển thị giá tiền
        $("#goi").on("change",function () {
        var selectedOption = $(this).find("option:selected"); 
        var price = selectedOption.attr("data-price") || 0;
        var formattedPrice = new Intl.NumberFormat('vi-VN').format(price) + " đ";
        // Cập nhật giá tiền trên giao diện
        $("#totalCost").text(formattedPrice);
        });
</script>
@endsection