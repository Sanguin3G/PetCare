<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $timestamp = true;
    use HasFactory;
}
