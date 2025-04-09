<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Log;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::paginate(10);
        $listStaff = Staff::all();
        $schedule = DB::table('schedules')
            ->join('staff', 'schedules.id_staff', '=', 'staff.id')
            ->select(
                'schedules.id as idSchedule',
                'schedules.time as TimeWork',
                'schedules.day as DayWord',
                'schedules.status as StatusSchedule',
                'staff.id as id',
                'staff.name as name',
            )
            ->orderBy('schedules.day', 'asc')
            ->paginate(10);
        return view('Admin.StaffView', ['staff' => $staff, 'schedule' => $schedule, 'listStaff' => $listStaff]);
    }
    public function create()
    {
        return view('Admin.CreateStaffView');
    }

    public function store(Request $request)
    {
        $staff = new Staff();
        try {
            DB::beginTransaction();
            $staff->name = $request->input('nameNV');
            $staff->email = $request->input('emailNV');
            $staff->local = $request->input('localNV');
            $staff->phone = $request->input('phoneNV');
            $staff->date = $request->input('dateNV');
            $staff->CMND = $request->input('CMND');
            $staff->sex = $request->input('sex');
            $staff->chucvu = $request->input('chucvu');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('assets/img-nhanvien/', $filename);
                $staff->image = $filename;
            }
            $staff->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Thêm nhân viên thành công !']);
        } catch (Throwable $e) {
            Log::error($e);
        }
    }
}
