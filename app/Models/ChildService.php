<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildService extends Model
{
    use HasFactory;
    protected $table = 'child_services';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['id', 'name', 'cost', 'type_pet', 'id_Service'];
    public function Services()
    {
        return $this->belongsTo(Service::class, 'id_Service');
    }
}
