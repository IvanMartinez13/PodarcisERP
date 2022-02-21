<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        "company",
        "nif",
        "location",
        "contact",
        "contact_mail",
        "phone",
        "token",
        "active",
        "user_id",
    ];

    public function manager()
    {
        return $this->hasOne(User::class);
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_customer');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
