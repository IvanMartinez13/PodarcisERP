<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "evaluations";

    protected $fillable = [
        'year',
        'value',
        'token',
        'strategy_id',
    ];

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }

    public function files()
    {
        return $this->hasMany(Evaluation_file::class);
    }
}
