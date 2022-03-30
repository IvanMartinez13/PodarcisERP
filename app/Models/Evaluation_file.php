<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation_file extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "evaluation_files";

    protected $fillable = [
        "name",
        "path",
        "evaluation_id",
        "token",
    ];
}
