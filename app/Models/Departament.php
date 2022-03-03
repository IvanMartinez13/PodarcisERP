<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departament extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "departaments";

    protected $fillable = [
        "name",
        "token",
    ];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, "departament_branch");
    }


    public function users()
    {
        return $this->belongsToMany(User::class, "departament_user");
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, "departament_task");
    }
}
