<?php

namespace App\Models;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SceneStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'scene_id',
        'step_order',
        'text',
        'bg_image',
        'bgm',
        'se',
    ];

    public function scene(): BelongsTo
    {
        return $this->belongsTo(Scene::class);
    }

    public function bgImageAsset()
    {
        return $this->belongsTo(Asset::class, 'bg_image', 'filename');
    }

    public function bgmAsset()
    {
        return $this->belongsTo(Asset::class, 'bgm', 'filename');
    }

    public function seAsset()
    {
        return $this->belongsTo(Asset::class, 'se', 'filename');
    }
}
