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
        "increase",
        "target",
        "base_year",
        "target_year",
        "token",
        "objective_id"
    ];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    public function task()
    {
        return $this->belongsToMany(Task::class, 'task_strategy');
    }
}
