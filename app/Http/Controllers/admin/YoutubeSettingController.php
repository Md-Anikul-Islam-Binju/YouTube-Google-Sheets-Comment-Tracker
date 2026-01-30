<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeSetting;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

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
        Toastr::success('Saved Successfully', 'Success');
        return redirect()->back();

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'video_id' => 'required',
            'sheet_id' => 'required',
        ]);

        $item = YoutubeSetting::findOrFail($id);

        $item->update([
            'video_id' => $request->video_id,
            'keywords' => explode(',', $request->keywords),
            'sheet_id' => $request->sheet_id,
            'is_active' => 1,
        ]);

        Toastr::success('Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        YoutubeSetting::findOrFail($id)->delete();
        Toastr::success('Deleted Successfully', 'Success');
        return redirect()->back();

    }
}
