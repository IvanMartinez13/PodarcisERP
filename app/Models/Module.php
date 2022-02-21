<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "modules";

    protected $fillable = [
        "name",
        "icon",
        "token",
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'module_customer');
    }
}
