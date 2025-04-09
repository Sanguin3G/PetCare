@extends('Admin.Layout')
@section('content')
@if (session('notice'))
<script>
    $.toast({
                heading: 'Thông báo',
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
                heading: 'Thông báo',
                text: '{{ session('error') }}',
                showHideTransition: 'slide',
                icon: 'error',
                position: 'bottom-right'
            })
</script>
@endif
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 22px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.book') }}">Danh sách lịch hẹn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
{{-- hoàn thành lịch hẹn --}}
@if ($book->status !== 2)
<button data-bs-toggle="modal" data-bs-target="#complete" class="btn btn-primary mb-2">Hoàn thành lịch
    hẹn</button>
<div class="modal fade" id="complete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông
                    báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('admin.bookCompletePost') }}">
                @csrf
                <div class="modal-body">
                    <h5>Xác nhận hoàn thành lịch hẹn</h5>
                    <input value="{{ $book->id }}" name="IdBookComplete" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Xác
                        nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<a href="{{ route('admin.bookInvoice', ['id' => $book->id]) }}"><button class="btn btn-primary mb-2">Xuất hóa
        đơn</button></a>
<div class="container-fluid border border-primary rounded">
    <div class="p-4">
        <div class="name d-inline-block">
            <span>
                <b class="me-3"> Tên khách hàng: <span class="text-danger">{{ $book->nameCus }}</span> </b>
            </span>
        </div>
        <div class="phone mt-4">
            <span>
                <b class="me-3">Số điện thoại: <span class="text-danger">{{ $book->phoneCus }}</span></b>
            </span>
        </div>
        <div class="namePet mt-4">
            <span>
                <b class="me-3">Tên Pet: <span class="text-danger">{{ $book->namePet }}</span></b>
            </span>
        </div>
        <div class="typePet mt-4">
            <span>
                <b class="me-3">Loại Pet: <span class="text-danger">{{ $book->typePet }}</span></b>
            </span>
        </div>
        <div class="weight mt-4">
            <span>
                <b class="me-3">Cân nặng: <span class="text-danger">{{ $book->petWeight }}</span> (kg)</b>
            </span>
        </div>
        <div class="nameService mt-4">
            <span>
                <b class="me-3">Tên dịch vụ: <span class="text-danger">{{ $book->nameService }}</span></b>
            </span>
        </div>
        <div class="goi mt-4">
            <span>
                <b class="me-3">Gói: <span class="text-danger">{{ $book->goi }}</span></b>
            </span>
        </div>
        <div class="dateBook mt-4">
            <span>
                <b class="me-3">Ngày hẹn: <span class="text-danger">{{ \Carbon\Carbon::parse((int)
                        $book->date)->format('d-m-Y H:i:s') }}</span></b>
            </span>
        </div>
        <div class="dateCre mt-4">
            <span>
                <b class="me-3">Ngày tạo: <span class="text-danger">{{
                        \Carbon\Carbon::parse($book->created_at)->format('d-m-Y H:i:s') }}</span></b>
            </span>
        </div>
        <div class="dateCre mt-4">
            <span>
                <b class="me-3">Thành tiền: <span class="text-danger">{{ number_format($book->cost) }}đ</span></b>
            </span>
        </div>

        <div class="local mt-4">
            @if ($book->status === 1)
            <button class="btn btn-success">Đã duyệt</button>
            @elseif ($book->status ===0)
            <button class="btn btn-danger">Chưa duyệt</button>
            @else
            <button class="btn btn-success">Đã hoàn thành</button>
            @endif

        </div>
    </div>
</div>
@endsection