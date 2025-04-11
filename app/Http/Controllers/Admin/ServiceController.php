<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Service;
use Illuminate\Http\Request;
use Throwable;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::paginate(10);
        return view('Admin.ServiceView', ['service' => $service]);
    }
    public function create()
    {
        return view('Admin.CreateServiceView');
    }
    public function store(Request $request)
    {
        try {
            $model = new Service();
            $result = $model->createServiceModel($request);
            if ($result === true) {
                return ApiResponse::Success(null, 'Thêm dịch vụ thành công !', 'success', 200);
            } elseif ($result === 'Existed') {
                return ApiResponse::Error(null, 'Dịch vụ đã tồn tại', 'success', 200);
            } else {
                return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
        }
    }
    public function edit($id)
    {
        $service = Service::where('id', $id)->first();
        return view('Admin.DetailServiceView', ['service' => $service]);
    }
    public function update($id, $request)
    {
        try {
            $model = new Service();
            $result = $model->updateModel($id, $request);
            if ($result === true) {
                return ApiResponse::Success(null, 'Cập nhật dịch vụ thành công !', 'success', 200);
            } elseif ($result === 'Existed') {
                return ApiResponse::Error(null, 'Dịch vụ đã tồn tại', 'success', 200);
            } else {
                return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
            }
        } catch (Throwable $e) {
            return ApiResponse::Error(null, "Có lỗi xảy ra", 'error', 500);
        }
    }
}
