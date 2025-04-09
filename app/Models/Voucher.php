<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';
    protected $primaryKey = 'id';
    public $timestamp = false;
    public $incrementing = false;
    public $keyType = 'string';
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($voucher) {
            do {
                $randomId = Str::random(10);
            } while (self::where('id', $randomId)->exists()); // Kiểm tra trùng lặp
            $voucher->id = $randomId;
        });
    }
}
