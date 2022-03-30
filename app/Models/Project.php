<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "projects";

    protected $fillable = [
        "name",
        "description",
        "color",
        "image",
        "token",
        "customer_id",
        "is_ods",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
