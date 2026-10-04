<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductUserController extends Controller
{
    public function index(Request $request, $id = 'all')
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100', 'category' => 'nullable|integer', 'sort' => 'nullable|in:recommended,newest,price-asc,price-desc']);
        $selectedCategory = $filters['category'] ?? (is_numeric($id) ? $id : null);
        $query = Product::with('ImageProduct');
        if ($selectedCategory) $query->where('idCat', $selectedCategory);
        $search = trim($filters['q'] ?? '');
        if ($search !== '') $query->where('namePro', 'like', '%'.$search.'%');
        $sort = $filters['sort'] ?? 'recommended';
        match ($sort) {
            'price-asc' => $query->orderByRaw('cost * (1 - COALESCE(discount, 0) / 100.0) asc'),
            'price-desc' => $query->orderByRaw('cost * (1 - COALESCE(discount, 0) / 100.0) desc'),
            'newest' => $query->latest(),
            default => $query->orderByDesc('hot')->latest(),
        };
        return view('User.ProductView', ['products' => $query->orderBy('idPro')->paginate(12)->withQueryString(), 'category' => Category::all(), 'selectedCategory' => $selectedCategory, 'search' => $search, 'sort' => $sort]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate(['q' => 'required|string|max:100']);
        $q = trim($validated['q']);
        if (mb_strlen($q) < 2) return response()->json(['data' => []]);
        $categories = Category::pluck('name', 'idCat');
        $products = Product::with('ImageProduct')->where('namePro', 'like', '%'.$q.'%')->orderByDesc('hot')->orderBy('namePro')->limit(6)->get();
        return response()->json(['data' => $products->map(fn ($product) => [
            'name' => $product->namePro, 'category' => $categories[$product->idCat] ?? '',
            'price' => round($product->cost * (1 - ($product->discount ?? 0) / 100)),
            'image' => $product->ImageProduct->first() ? asset('assets/img-add-pro/'.$product->ImageProduct->first()->image) : asset('assets/img/PetCARE.png'),
            'url' => route('user.productDetail', ['id' => $product->idPro, 'name' => Str::slug($product->namePro) ?: 'product']),
        ])]);
    }

    public function getProductAjax(Request $request)
    {
        $request->validate(['field' => 'nullable|in:idPro,cost,namePro,created_at', 'sort' => 'nullable|in:asc,desc', 'category' => 'nullable|integer']);
        $query = Product::with('ImageProduct');
        if ($request->filled('category')) $query->where('idCat', $request->category);
        return response()->json(['status' => 'success', 'message' => 'Thành công', 'data' => $query->orderBy($request->input('field', 'created_at'), $request->input('sort', 'desc'))->limit(60)->get()]);
    }

    public function getDetail($id, $name)
    {
        $product = Product::with('ImageProduct')->findOrFail($id);
        $productRelated = Product::with('ImageProduct')->where('idCat', $product->idCat)->where('idPro', '!=', $id)->limit(4)->get();
        return view('User.ProductDetailView', compact('product', 'productRelated'));
    }
}
