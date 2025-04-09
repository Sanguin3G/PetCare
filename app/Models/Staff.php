<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamp = true;
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($staff) {
            do {
                $randomId = Str::random(10);
            } while (self::where('id', $randomId)->exists()); // Kiểm tra trùng lặp
            $staff->id = $randomId;
        });
    }
}
