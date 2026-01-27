<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeSetting;
use Illuminate\Http\Request;

class YoutubeSettingController extends Controller
{
    public function index()
    {
        return view('admin.youtube.index', [
            'items' => YoutubeSetting::all()
        ]);
    }

    public function store(Request $request)
    {
        YoutubeSetting::create([
            'video_id' => $request->video_id,
            'keywords' => explode(',', $request->keywords),
            'sheet_id' => $request->sheet_id,
            'is_active' => 1
        ]);

        return back()->with('success','Saved successfully');
    }
}
