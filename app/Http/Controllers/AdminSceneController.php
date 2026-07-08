<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SceneRequest;
use App\Http\Requests\StepRequest;
use App\Http\Requests\ChoiceRequest;
use App\Models\Scene;
use App\Models\SceneStep;
use App\Models\Choice;
use App\Models\Asset;

class AdminSceneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scenes = Scene::orderby('id', 'asc')->get();
        return view('admin.scenes.index', compact('scenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $baseTitle = '新規シーン';
        $title = $baseTitle;

        $existingTitles = Scene::where('title', 'LIKE', $baseTitle . '%')->pluck('title')->toArray();
        if(in_array($baseTitle, $existingTitles)){
            $count = 1;
            while(in_array($baseTitle . $count, $existingTitles)){
                $count++;
            }
            $title = $baseTitle . $count;
        }
        Scene::create([
            'title' => $title,
        ]);
        return redirect()->route('admin.scenes.index')->with('success', "{$title}を追加しました。");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scene = Scene::with(['sceneSteps', 'choices'])->findOrFail($id);
        return view('admin.scenes.show', compact('scene'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SceneRequest $request, Scene $scene)
    {
        $validated = $request->validated();
        $scene->update($validated);
        return redirect()->route('admin.scenes.show', $scene->id)->with('success', 'シーン名を変更しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scene $scene)
    {
        $scene->delete();
        return redirect()->route('admin.scenes.index')->with('success', 'シーンを削除しました。');
    }

    public function createStep(Scene $scene)
    {
        $maxOrder = $scene->sceneSteps()->max('step_order') ?? 0;
        $nextOrder = $maxOrder + 1;
        $bgImages = Asset::where('type', 'image')->get();
        $bgms = Asset::where('type', 'bgm')->get();
        $ses = Asset::where('type', 'se')->get();
        return view('admin.scenes.edit_step', compact('scene', 'nextOrder', 'bgImages', 'bgms', 'ses'));
    }

    public function storeStep(StepRequest $request, Scene $scene)
    {
        $validated = $request->validated();

        $targetOrder = (int)$validated['step_order'];
        $scene->sceneSteps()->where('step_order', '>=', $targetOrder)->increment('step_order');

        $scene->sceneSteps()->create([
            'step_order' => $targetOrder,
            'text' => $validated['text'],
            'bg_image' => $validated['bg_image'],
            'bgm' => $validated['bgm'],
            'se' => $validated['se'],
        ]);

        return redirect()->route('admin.scenes.show', $scene->id)->with('success', 'ステップを追加しました。');
    }

    public function editStep(Scene $scene, SceneStep $step)
    {
        $bgImages = Asset::where('type', 'image')->get();
        $bgms = Asset::where('type', 'bgm')->get();
        $ses = Asset::where('type', 'se')->get();
        return view('admin.scenes.edit_step', compact('scene', 'step', 'bgImages', 'bgms', 'ses'));
    }

    public function updateStep(StepRequest $request, Scene $scene, SceneStep $step)
    {
        $validated = $request->validated();

        $oldOrder = $step->step_order;
        $newOrder = (int)$validated['step_order'];

        if($oldOrder !== $newOrder){
            if($newOrder < $oldOrder){
                $scene->sceneSteps()->where('step_order', '>=', $newOrder)->where('step_order', '<', $oldOrder)->increment('step_order');
            }else{
                $scene->sceneSteps()->where('step_order', '>', $oldOrder)->where('step_order', '<=', $newOrder)->decrement('step_order');
            }
        }

        $step->update([
            'step_order' => $newOrder,
            'text' => $validated['text'],
            'bg_image' => $validated['bg_image'],
            'bgm' => $validated['bgm'],
            'se' => $validated['se'],
        ]);

        return redirect()->route('admin.scenes.show', $scene->id)->with('success', 'ステップを更新しました。');
    }

    public function destroyStep(Scene $scene, SceneStep $step)
    {
        $deletedOrder = $step->step_order;

        $step->delete();

        $scene->sceneSteps()->where('step_order', '>', $deletedOrder)->decrement('step_order');
        return redirect()->route('admin.scenes.show', $scene->id)->with('success', 'ステップを消去しました。');
    }

    public function createChoice(Scene $scene)
    {
        $scenes = Scene::select('id', 'title')->get();
        return view('admin.scenes.edit_choice', compact('scene', 'scenes'));
    }

    public function storeChoice(ChoiceRequest $request, Scene $scene)
    {
        $validated = $request->validated();
        $scene->choices()->create($validated);

        return redirect()->route('admin.scenes.show', $scene->id)->with('success', '選択肢を追加しました。');
    }

    public function editChoice(Scene $scene, Choice $choice)
    {
        $scenes = Scene::select('id', 'title')->get();
        return view('admin.scenes.edit_choice', compact('scene', 'choice', 'scenes'));
    }

    public function updateChoice(ChoiceRequest $request, Scene $scene, Choice $choice)
    {
        $validated = $request->validated();
        $choice->update($validated);

        return redirect()->route('admin.scenes.show', $scene->id)->with('success', '選択肢を更新しました。');
    }

    public function destroyChoice(Scene $scene, Choice $choice)
    {
        $choice->delete();
        return redirect()->route('admin.scenes.show', $scene->id)->with('success', '選択肢を消去しました。');
    }
}
