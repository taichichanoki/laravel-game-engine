<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRequest;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaveController extends Controller
{
    public function save(SaveRequest $request)
    {
        $save = Save::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'slot' => $request->slot,
            ],
            [
                'scene_id' => $request->scene_id,
                'step_order' => $request->step_order,
                'energy' => $request->energy,
                'alignment' => $request->alignment,
                'affection' => $request->affection,
            ]
        );

        $save->touch();

        return response()->json([
            'success' => true,
            'message' => 'セーブが完了しました。',
            'updated_at' => $save->updated_at->format('Y/m/d H:i')
        ]);
    }

    public function load($slot)
    {
        $save = Save::where('user_id', Auth::id())->where('slot', $slot)->first();
        if(!$save){
            return response()->json([
                'success' => false,
                'message' => 'セーブデータが見つかりません。'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'save' => $save
        ]);
    }
}
