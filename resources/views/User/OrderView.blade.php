{{-- @extends('User.LayoutTrangChu')
@section('content') --}}
<div class="ms-3" style="margin-top:250px;min-height:800px">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" style="font-size:2vw;font-size:2vh" data-bs-toggle="tab"
                data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                aria-selected="true">Giỏ hàng của bạn</button>
        </li>
    </ul>
    <div class="tab-content container-fluid d-flex align-items-center justify-content-center flex-column flex-wrap"
        id="myTabContent">
        {{-- cartSmallView --}}
        <div class="cartSmallView mt-2 tab-pane fade show active " id="home-tab-pane" role="tabpanel"
            aria-labelledby="home-tab" tabindex="0">
            {{-- @if ($OrderCount == 0)
            <h3 class="mt-3">Bạn chưa có đơn hàng nào. Hãy quay lại trang chủ để mua sắm</h3>
            @else --}}
            <section class="h-100" style="background-color: #d2c9ff;">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12">
                            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-lg-12">
                                            <div class="p-5">
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h2 style="font-size:2vw;font-size:2vh">Đơn hàng <i
                                                            class="fa-solid fa-cart-plus"></i></h2>
                                                    <h2 style="font-size:2vw;font-size:2vh" class="mb-0 totalOrder ">
                                                        {{ $Order->count() }} đơn hàng</h2>
                                                </div>
                                                <hr class="my-4">
                                                @foreach ($Order as $order)
                                                <div>
                                                    <div
                                                        class="row mb-0 d-flex justify-content-between align-items-center">
                                                        @foreach ($order->OrderDetail as $row)
                                                        <div class="col-md-3 col-lg-3 col-xl-3 mb-4">
                                                            <img src="{{ asset('assets/img-add-pro/' . $row->ProductDetail->ImageProduct[0]->image) }}"
                                                                class="img-fluid rounded-3" alt="Cotton T-shirt">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            {{-- <h6 class="text-muted">Shirt</h6> --}}
                                                            <h6 style="font-size:2.5vw;font-size:2.5vh" class="mb-0">
                                                                {{ $row->ProductDetail->namePro }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 d-flex">
                                                            <h5>x{{ $row->number }}</h5>
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3 offset-lg-1 text-danger">
                                                            <h5>
                                                                {{ $row->TotalCostOfProduct }}đ
                                                            </h5>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="text-end">
                                                        <h6 class="text-danger"><b> Tổng tiền :
                                                                {{ $order->totalCost
                                                                }}đ</b>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <h6 class="text-end"> <i
                                                                class="fa-solid fa-bag-shopping text-danger"></i>
                                                            Phương
                                                            thức thanh
                                                            toán: <span style="font-weight:bold">
                                                                {{ $order->thanhtoan }}</span> </h6>
                                                        @if ($order->status == 0)
                                                        <div class="text-end"><button class="btn btn-warning m-2">Chờ
                                                                xác
                                                                nhận</button> </div>
                                                        <div><button class="btn btn-danger cancel-order"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#cancel_order{{ $order->id }}">Hủy
                                                                đơn</button>
                                                        </div>
                                                        {{-- modal thông báo xác nhận xóa đơn hàng --}}
                                                        <div class="modal fade" id="cancel_order{{ $order->id }}"
                                                            tabindex="-1" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 style="font-size:1.3vh;font-size:1.3vw"
                                                                            class="modal-title fs-5"
                                                                            id="exampleModalLabel">
                                                                            Thông
                                                                            báo
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body"
                                                                        style="font-size:1.3vh;font-size:1.3vw">
                                                                        Bạn có muốn hủy đơn hàng này
                                                                        không ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-bs-dismiss="modal"
                                                                            style="font-size:1.3vh;font-size:1.3vw">Đóng</button>

                                                                        <button type="button" class="btn btn-primary">
                                                                            @csrf<a
                                                                                style="text-decoration:none;color:white;font-size:1.3vh;font-size:1.3vw">Đồng
                                                                                ý</a></button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="text-end"><button class="btn btn-success m-2">Đơn
                                                                hàng
                                                                đang được giao</button> </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-end"></div>
                                                <hr class="my-4">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }

        .order {
            flex: 1;
        }

        .booking {
            flex: 1;
        }

        @media screen and (max-width: 860px) {
            .orderUser {
                margin-top: 250px;
            }
        }
    </style>
</div>
{{-- @vite('resources/js/User/order/getOrder.js') --}}
{{-- @endsection --}}