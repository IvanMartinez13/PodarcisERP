<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "visits";

    protected $fillable = [
        "name",
        "description",
        "starts_at",
        "ends_at",
        "color",
        "token",
        "compilance",
        "vao_id",
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, "visit_user");
    }
}
