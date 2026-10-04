@extends('User.LayoutTrangChu')
@section('content')
<div class="pc-shop-page container">
    <div class="pc-section-heading"><div><span class="pc-section-kicker">Chọn điều tốt cho bé</span><h1>Cửa hàng PetCare</h1></div><p>Thức ăn, đồ chơi và phụ kiện cho những ngày vui bên thú cưng.</p></div>
    <form class="pc-filter-form" method="get" action="{{ route('user.product', ['id' => 'all']) }}">
        <div class="pc-filter-search"><label for="catalog-search">Tìm sản phẩm</label><input class="form-control" id="catalog-search" type="search" name="q" value="{{ $search }}" maxlength="100" placeholder="Tên sản phẩm…"></div>
        <div><label for="catalog-category">Danh mục</label><select class="form-select" id="catalog-category" name="category"><option value="">Tất cả danh mục</option>@foreach ($category as $row)<option value="{{ $row->idCat }}" @selected($selectedCategory == $row->idCat)>{{ $row->name }}</option>@endforeach</select></div>
        <div><label for="catalog-sort">Sắp xếp</label><select class="form-select" id="catalog-sort" name="sort">@foreach (['recommended' => 'Nổi bật', 'newest' => 'Mới nhất', 'price-asc' => 'Giá: thấp đến cao', 'price-desc' => 'Giá: cao đến thấp'] as $value => $label)<option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>@endforeach</select></div>
        <button class="btn pc-primary-cta" type="submit">Áp dụng</button>
    </form>
    <div class="pc-results-meta"><p><strong>{{ $products->total() }}</strong> sản phẩm @if ($search) cho “{{ $search }}” @endif</p>@if ($search || $selectedCategory || $sort !== 'recommended')<a href="{{ route('user.product', ['id' => 'all']) }}">Xóa bộ lọc</a>@endif</div>
    <div class="pc-shop-grid">@foreach ($products as $product) @include('User.partials.product-card') @endforeach</div>
    @if ($products->isEmpty())<div class="pc-empty-state"><i class="fa-solid fa-paw" aria-hidden="true"></i><h2>Chưa tìm thấy sản phẩm</h2><p>Thử tên khác hoặc xem tất cả danh mục.</p><a class="btn pc-primary-cta" href="{{ route('user.product', ['id' => 'all']) }}">Xem tất cả sản phẩm</a></div>@endif
    <div class="pc-pagination">{{ $products->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
