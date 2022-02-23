<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "branches";

    protected $fillable = [
        "name",
        "location",
        "coordinates",
        "token",
        "customer_id",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "branch_user");
    }

    public function departaments()
    {
        return $this->belongsToMany(Departament::class, "departament_branch");
    }
}
