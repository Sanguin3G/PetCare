<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = "id";
    protected $keyType = 'string';
    protected $fillable = ['id', 'message', 'id_sender', 'id_receiver', 'type_sender', 'type_message', 'status'];
    protected $cast = [
        'status' => 'boolean',
    ];
}
