<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scene extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function sceneSteps(): HasMany
    {
        return $this->hasMany(SceneStep::class)->orderBy('step_order', 'asc');
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}
