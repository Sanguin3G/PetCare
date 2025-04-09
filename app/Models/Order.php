<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamp = true;
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['idCus', 'status', 'address', 'note', 'thanhtoan', 'idVoucher', 'created_at'];
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            do {
                $randomId = Str::upper(Str::random(10));
            } while (self::where('id', $randomId)->exists()); // Kiểm tra trùng lặp
            $order->id = $randomId;
        });
    }
}
