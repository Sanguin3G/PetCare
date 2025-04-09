<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Staff;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    public $timestamp = true;
    use HasFactory;

    public function Staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
