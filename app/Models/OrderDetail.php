<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'id';
    public $timestamp = true;
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = ['number', 'idPro', 'price', 'idOrder'];
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($orderDetail) {
            do {
                $randomId = Str::random(10);
            } while (self::where('id', $randomId)->exists()); // Kiểm tra trùng lặp
            $orderDetail->id = $randomId;
        });
    }
}
