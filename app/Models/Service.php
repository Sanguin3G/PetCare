<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\File;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = true;
    protected $fillable = ['id', 'name', 'image'];

    public function createServiceModel($request)
    {
        $service = new Service();
        try {
            DB::beginTransaction();
            $fetch = Service::where('name', $request->nameDM)->first();
            if ($fetch) {
                return 'Existed';
            }
            $service->name = $request->nameDM;
            if ($request->hasFile('imageService')) {
                $file = $request->file('imageService');
                $extension = $file->getClientOriginalExtension(); //lay tep mo rong cua file
                $filename = time() . '.' . $extension;
                $file->move('assets/img-dichvu', $filename);
                $service->image = $filename;
            }
            $service->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'error';
        }
    }
    public function updateModel($id, $request)
    {
        try {
            DB::beginTransaction();
            $fetch = Service::where('name', $request->nameDM)->first();
            if ($fetch) {
                return 'Existed';
            }
            $service = Service::find($id);
            $service->name = $request->nameDM;
            if ($request->hasFile('imageService')) {
                $file = $request->file('imageService');
                $extension = $file->getClientOriginalExtension(); //lay tep mo rong cua file
                $filename = time() . '.' . $extension;
                $file->move('assets/img-dichvu', $filename);
                $service->image = $filename;
                if (File::exists('assets/img-add-pro/' . $service->image)) {
                    File::delete('assets/img-add-pro/' . $service->image);
                }
            }
            $service->save();
            DB::commit();
            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return 'error';
        }
    }
}
