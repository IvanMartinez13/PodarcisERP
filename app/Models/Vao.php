<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "Vao";

    protected $fillable = [
        "title",
        "description",
        "starts_at",
        "code",
        "state",
        "location",
        "direction",
        "image",
        "customer_id",
        "token"
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
