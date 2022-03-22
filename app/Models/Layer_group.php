<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layer_group extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "layer_groups";

    protected $fillable = [
        'name',
        'vao_id',
        'token'
    ];

    
}
