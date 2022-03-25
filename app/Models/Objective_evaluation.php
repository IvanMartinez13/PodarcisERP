<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective_evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "objective_evaluations";

    protected $fillable = [
        'year',
        'value',
        'token',
        'objective_id'
    ];

    public function files()
    {
        return $this->hasMany(Objective_evaluation_file::class);
    }
}
