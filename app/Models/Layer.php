<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layer extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "layers";

    protected $fillable = [
        "name",
        "type",
        "layer_group_id",
        "vao_id",
        "token",
        "path",
        
    ];

    public function group()
    {
        return $this->belongsTo(Layer_group::class, 'layer_group_id', 'id');
    }
}
