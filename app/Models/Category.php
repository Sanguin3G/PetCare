<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $primaryKey = 'idCat';
    public $timestamp = true;
    protected $fillable = ['name'];
    /**
     * @param $request
     * @return array|string
     */
    public function createCategory($request): array|string
    {
        try {
            $name = $request->name;
            $cat = Category::where('name', $name)->exists();
            if ($cat) {
                return 'Category has existed !';
            }
            DB::beginTransaction();
            $Category = Category::create([
                'name' => $request->name
            ]);
            DB::commit();
            return [
                'idCat' => $Category->idCat,
                'name' => $Category->name,
            ];
        } catch (Throwable $e) {
            Log::error($e);
            DB::rollBack();
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     */
    public function deleteCategory($request): string
    {
        try {
            DB::beginTransaction();
            $cat = Category::find($request->idCat);
            if (!$cat) {
                return 'Not Found';
            }
            $cat->delete();
            DB::commit();
            return 'true';
        } catch (Throwable $e) {
            DB::rollBack();
            return 'error';
        }
    }
    /**
     * @param $request
     * @return string
     */
    public function updateCategory($request): string
    {
        try {
            DB::beginTransaction();
            $cat = Category::find($request->idCat);
            if (!$cat) {
                return 'Not Found';
            }
            $nameExists = Category::where('name', $request->name)
                ->first();
            // if name was existed return 
            if ($nameExists) {
                Log::error($nameExists ? 'true' : 'false');
                return 'Name has existed';
            }
            $cat->name = $request->name;
            $cat->save();
            DB::commit();
            return 'success';
        } catch (Throwable $e) {
            DB::rollBack();
            return 'error';
        }
    }
}
