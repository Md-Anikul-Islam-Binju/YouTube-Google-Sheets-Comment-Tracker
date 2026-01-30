<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Count of total video IDs (number of entries with non-empty video_id)
        $totalVideosLink = YoutubeSetting::whereNotNull('video_id')->count();

        // Count of total sheet IDs (number of entries with non-empty sheet_id)
        $totalSheetLink = YoutubeSetting::whereNotNull('sheet_id')->count();

        return view('admin.dashboard', compact('totalVideosLink', 'totalSheetLink'));
    }

}
