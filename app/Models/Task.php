<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tasks";

    protected $fillable = [
        "name",
        "description",
        "is_done",
        "token",
        "project_id",
        "task_id"
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function departaments()
    {
        return $this->belongsToMany(Departament::class, "departament_task");
    }

    public function strategy()
    {
        return $this->belongsToMany(Strategy::class, 'task_strategy');
    }

    public function objective()
    {
        return $this->belongsToMany(Objective::class, 'task_objective');
    }
}
