<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\ImageProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $primaryKey = 'idPro';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamp = true;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            do {
                $randomId = Str::upper(Str::random(10));
            } while (self::where('idPro', $randomId)->exists());
            $product->idPro = $randomId;
        });
    }
    public function ImageProduct()
    {
        return $this->hasMany(ImageProduct::class, 'idPro', 'idPro');
    }
    /**
     * Get List Product order by IdPro desc
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null 
     */
    public function getListproduct(): LengthAwarePaginator|null
    {
        try {
            $products = Product::with('ImageProduct')->orderBy('idPro', 'desc')->paginate(5);
            return $products;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * @param string $id
     * @param string $name
     * @return array|null
     */
    public function editModel(string $id, string $name): ?array
    {
        try {
            $product = Product::with('ImageProduct')->where('idPro', $id)->first();
            $category = Cache::remember('list_category', 1440, function () {
                return Category::all();
            });
            $nameCat = Category::where('idCat', $product->idCat)->select('name', 'idCat')->first();
            return [
                'category' => $category,
                'product' => $product,
                'nameCat' => $nameCat->name
            ];
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * @param string $id
     * @param $request
     * @return string
     */
    public function updateModel($id, $request): string
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            if (!$product) {
                return 'Not Found';
            }
            $product->namePro = $request->namepro;
            $product->description = $request->mota;
            $product->count = (int)$request->countpro;
            $product->hot = 0;
            $product->cost = (int)$request->giabanpro;
            $product->discount = (int)$request->discount ? (int)$request->discount : 0;
            $product->idCat = (int)$request->danhmucAddpro;
            $product->save();
            // If request send file image, delete old image
            if ($request->UpdateImage === 'true' && $request->file('imagepro')) {
                $files = $request->file('imagepro');
                $indexImg = 0;
                foreach ($files as $value) {
                    $indexImg++;
                    $extension = $value->getClientOriginalExtension(); //get extension of file
                    $filename =    $indexImg . time() . '.' . $extension;
                    $value->move('assets/img-add-pro/', $filename);
                    $imageProduct = ImageProduct::create([
                        'idPro' => $product->idPro,
                        'image' => $filename
                    ]);
                    $imageProduct->save();
                }
            }
            DB::commit();
            return 'success';
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'error';
        }
    }
    /**
     * @param string $id
     * @return string
     */
    public function getImgProduct($id): string
    {
        $img = DB::table('image_products')->select('image')->where('idPro', $id)->limit(1)->first();
        return $img->image;
    }
    /**
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getListCategory(): ?Collection
    {
        try {
            // $cat = DB::table("categories")->select("name", "idCat")->get();
            // $cat = Cache::remember('list_category', 1440, function () {
            //     return DB::table("categories")->select("name", "idCat")->get();
            // });
            $cat = DB::table("categories")->select("name", "idCat")->get();
            return $cat;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * @param $request
     * @return bool
     */
    public function StoreProductModel($request): bool
    {
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->namePro = $request->namepro;
            $product->description = $request->mota;
            $product->count = (int)$request->countpro;
            $product->hot = 0;
            $product->cost = (int)$request->giabanpro;
            $product->discount = (int)$request->discount ? (int)$request->discount : 0;
            $product->idCat = (int)$request->danhmucAddpro;
            $product->save();
            $indexImg = 0;
            if ($files = $request->file('imagepro')) {
                foreach ($files as $value) {
                    $indexImg++;
                    $extension = $value->getClientOriginalExtension(); //lay tep mo rong cua file
                    $filename =    $indexImg . time() . '.' . $extension;
                    $value->move('assets/img-add-pro/', $filename);
                    $imageProduct = ImageProduct::create([
                        'idPro' => $product->idPro,
                        'image' => $filename
                    ]);
                    $imageProduct->save();
                }
            }
            DB::commit();
            return true;
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return false;
        }
    }
    /**
     * @param $request
     * @return bool
     */
    public function deleteModel($request): bool
    {
        try {
            DB::beginTransaction();
            $imageProduct = ImageProduct::where('idPro', $request->idPro)->select('id', 'idPro', 'image')->get();
            foreach ($imageProduct as $row) {
                if (File::exists('assets/img-add-pro/' . $row->image)) {
                    File::delete('assets/img-add-pro/' . $row->image);
                }
            }
            Product::where('idPro', $request->idPro)->delete();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    /**
     * @param $request
     * @return bool
     */
    public function deleteImageProductModel($request): bool
    {
        try {
            DB::beginTransaction();
            $image = ImageProduct::find($request->id);
            if (File::exists('assets/img-add-pro/' . $image->image)) {
                File::delete('assets/img-add-pro/' . $image->image);
            }
            $image->delete();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return false;
        }
    }
    /**
     * 
     *
     * @param int $id 
     * @param string|null $name 
     * @return \App\Models\Product|null 
     */
    public function getDetailProductModel($id, $name): ?Product
    {
        try {
            $product = Product::with("ImageProduct")->where("idPro", $id)->first();
            return $product;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     *
     * @param int $id 
     * @return \Illuminate\Support\Collection|null 
     */
    public function getRelatedProduct($id): ?Collection
    {
        try {
            $product = Product::find($id);
            $idCat = $product->idCat;
            $product = Product::with("ImageProduct")->where("idCat", $idCat)->where("idPro", '!=', $id)->get();
            return $product;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
    /**
     * @param string $text
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|null 
     */
    // Find product by name
    public function getListProductByName(String $text): ?LengthAwarePaginator
    {
        try {
            // Log::info($text);
            $product = Product::with('ImageProduct')->where('namePro', 'LIKE', '%' . $text . '%')->orderBy('idPro', 'desc')->paginate(5);
            // Log::info($text);
            return $product;
        } catch (Throwable $e) {
            Log::error($e);
            return null;
        }
    }
}
