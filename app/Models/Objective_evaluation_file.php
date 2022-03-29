<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective_evaluation_file extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "Objective_evaluation_files";

    protected $fillable = [
        "name",
        "path",
        "objective_evaluation_id",
        "token",
    ];
}
