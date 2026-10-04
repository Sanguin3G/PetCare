@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1 style="">Danh Sách Đơn Hàng</h1>

</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="search mt-4 mb-4 input-group" style="width:50%">
      <span class="input-group-text btn btn-success" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>
      <input style="" class="form-control" type="text" id="searchOrders" aria-label="Tìm Đơn hàng trên trang này…" placeholder="Tìm Đơn hàng trên trang này…">
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body table-responsive mt-2">
          <!-- Table with stripped rows -->
          <table style="" class="table text-center" border="1">
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
              @forelse ($Order as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</td>
                <td class="order-status">@if ($order->status < 0)<span class="badge bg-danger">Đã hủy</span>@elseif ($order->status > 0)<span class="badge bg-success">Đã giao hàng</span>@else<span class="badge bg-secondary">Chưa giao hàng</span>@endif</td>

                <td>
                  @if ($order->status == 0)<button class="btn btn-success btn-delivery" data-id="{{ $order->id }}" title="Xác nhận đã giao" aria-label="Xác nhận đã giao"><i class="fa-solid fa-truck" aria-hidden="true"></i></button>@endif
                  <button style="" class="btn btn-primary btn-getdetail-order"
                    data-id="{{ $order->id }}">Xem
                  </button>

                </td>
              </tr>
              @empty
<tr><td colspan="9" class="text-center py-5">Chưa có dữ liệu để hiển thị.</td></tr>
@endforelse

            </tbody>
          </table>
        </div>
      </div>
      {{ $Order->links('pagination::bootstrap-5') }}
    </div>
  </div>
</section>
@vite('resources/js/Admin/order/detail.js')

@endsection