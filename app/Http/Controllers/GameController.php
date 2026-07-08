<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index()
    {
        $savedSlots = Save::where('user_id', Auth::id())->get()->keyBy('slot');
        return view('game', compact('savedSlots'));
    }

    public function getScene($id = 1)
    {
        $scene = DB::table('scenes')->where('id', $id)->first();
        if(!$scene){
            return response()->json(['error' => 'Scene not found'], 404);
        }

        $steps = DB::table('scene_steps')->where('scene_id', $id)->orderBy('step_order', 'asc')->get();

        $choices = DB::table('choices')->where('scene_id', $id)->get();
        return response()->json(compact('scene', 'steps', 'choices'));
    }
}
