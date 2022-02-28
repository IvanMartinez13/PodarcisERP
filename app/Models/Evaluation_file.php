<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation_file extends Model
{
    use HasFactory;

    protected $table = "evaluation_files";

    protected $fillable = [
        "name",
        "path",
        "evaluation_id",
        "token",
    ];
}
