<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slot',
        'scene_id',
        'step_order',
        'energy',
        'alignment',
        'affection',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
