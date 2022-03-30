<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "objectives";

    protected $fillable = [
        "title",
        "description",
        "indicator",
        "increase",
        "target",
        "base_year",
        "target_year",
        "token",
        "customer_id"
    ];

    public function customer()
    {
        $this->belongsTo(Customer::class);
    }

    public function task()
    {
        return $this->belongsToMany(Task::class, 'task_objective');
    }
}
