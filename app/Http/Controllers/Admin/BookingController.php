<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        // $book = Booking::all();
        $book = DB::table('bookings as b')->join('services as s', 'b.name_service', '=', 's.id')->join('customer as c', 'c.id', '=', 'b.idCus')->select('b.id', 'c.name as nameCus', 'b.date', 's.name as nameService', 'b.status')->paginate(10);
        // dd($book);
        return view('Admin.BookingView', ['book' => $book]);
    }
}
