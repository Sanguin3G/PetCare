<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class VoucherUser extends Model
{
    use HasFactory;
    protected $table = 'voucher_users';
    protected $primaryKey = 'id';
    public $timestamp = false;
    public $incrementing = false;
    public $keyType = 'string';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($voucherUser) {
            do {
                $randomId = Str::random(10); // Tạo chuỗi ngẫu nhiên 10 ký tự
            } while (self::where('id', $randomId)->exists()); // Kiểm tra trùng lặp
            $voucherUser->id = $randomId;
        });
    }
}
