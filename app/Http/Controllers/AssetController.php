<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Requests\AssetRequest;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::all();
        return view('admin.assets.index', compact('assets'));
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
    public function store(AssetRequest $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        if(Asset::where('filename', $filename)->exists()){
            return back()->withErrors(['file' => 'このファイル名は既に登録されています。']);
        }

        switch($request->type){
            case 'image':
                $targetFolder = 'images';
                break;
            case 'bgm':
                $targetFolder = 'bgms';
                break;
            case 'se':
                $targetFolder = 'ses';
                break;
            default:
                return back()->withErrors(['type' => '種類はimage, bgm, seのいずれかを設定してください。']);
        }

        $destinationPath = public_path($targetFolder);
        if(!file_exists($destinationPath)){
            mkdir($destinationPath, 0755, true);
        }

        try{
            $file->move($destinationPath, $filename);
        }catch(\Exception $e){
            return back()->withErrors(['file' => 'ファイルの保存に失敗しました。フォルダの権限を確認してください:' . $e->getMessage()]);
        }

        Asset::create([
            'name' => $request->name,
            'filename' => $filename,
            'type' => $request->type,
        ]);

        return redirect()->route('admin.assets.index')->with('success', '新しい素材をアップロードし、登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        switch($asset->type){
            case 'image':
                $targetFolder = 'images';
                break;
            case 'bgm':
                $targetFolder = 'bgms';
                break;
            case 'se':
                $targetFolder = 'ses';
                break;
            default:
                $targetFolder = null;
        }
        if($targetFolder){
            $filePath = public_path($targetFolder . '/' . $asset->filename);
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }

        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', '素材を消去しました。');
    }
}
