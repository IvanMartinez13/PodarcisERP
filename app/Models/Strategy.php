<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strategy extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "strategies";

    protected $fillable = [
        "title",
        "description",
        "performances",
        "indicator",
        "token",
        "objective_id"
    ];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
