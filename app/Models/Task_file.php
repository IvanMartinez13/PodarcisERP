<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task_file extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "task_files";

    protected $fillable = [
        "name",
        "task_id",
        "path",
        "token"
    ];

}
