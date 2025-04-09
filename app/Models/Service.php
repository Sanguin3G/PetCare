<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = true;
    protected $fillable = ['id', 'name', 'image'];
}
