<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'scene_id',
        'text',
        'next_scene_id',
        'min_energy_required',
        'min_alignment_required',
        'max_alignment_required',
        'min_affection_required',
        'energy_change',
        'alignment_change',
        'affection_change',
    ];

    public function scene(): BelongsTo
    {
        return $this->belongsTo(Scene::class, 'scene_id');
    }

    public function nextScene(): BelongsTo
    {
        return $this->belongsTo(Scene::class, 'next_scene_id');
    }
}
