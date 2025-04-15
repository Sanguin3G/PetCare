@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1 style="font-size:2.5vw;font-size:2.5vh">Danh Sách Đơn Hàng</h1>

</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="search mt-4 mb-4 input-group" style="width:50%">
      <button class="input-group-text btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
      <input style="font-size:2vw;font-size:2vh" class="form-control" type="text" id="searchOrders">
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body table-responsive mt-2">
          <!-- Table with stripped rows -->
          <table style="font-size:2vw;font-size:2vh" class="table text-center" border="1">
            <thead>
              <tr class="table-secondary text-center">
                <th>
                  <b>I</b>D đơn hàng
                </th>
                <th>Khách Hàng </th>
                <th>Số điện thoại</th>
                <th>Ngày đặt</th>
                <th>Tình trạng</th>
                <th>Tính năng</th>
              </tr>
            </thead>

            <tbody id="table-order">
              @foreach ($Order as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</td>
                @if ($order->status > 0)
                <td><button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-delivery-success">Đã giao
                    hàng</button> </td>
                @else
                <td class="btn-no-delivery" data-id="{{ $order->id }}"><button style="font-size:2vw;font-size:2vh"
                    class="btn btn-danger">Chưa giao
                    hàng</button> </td>
                @endif

                <td>
                  <a> <button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-đelivery"
                      data-id="{{ $order->id }}"><i class="fa-solid fa-truck"></i></button></a>
                  <button style="font-size:2vw;font-size:2vh" class="btn btn-primary btn-getdetail-order"
                    data-id="{{ $order->id }}">Xem
                  </button>

                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
      {{ $Order->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@vite('resources/js/Admin/order/detail.js')
<script>
  const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            toastTrigger.addEventListener('click', () => {
                toastBootstrap.show()
            })
        }
</script>
@endsection