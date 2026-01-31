<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Count of total video IDs (number of entries with non-empty video_id)
        $totalVideosLink = YoutubeSetting::whereNotNull('video_id')->count();
        // Count of total sheet IDs (number of entries with non-empty sheet_id)
        $totalSheetLink = YoutubeSetting::whereNotNull('sheet_id')->count();

        // Path to JSON file
        $clientEmail = null;
        $jsonPath = 'google/service-account.json';
        if (Storage::exists($jsonPath)) {
            $json = json_decode(Storage::get($jsonPath), true);
            $clientEmail = $json['client_email'] ?? null;
        }

        return view('admin.dashboard', compact('totalVideosLink', 'totalSheetLink', 'clientEmail'));
    }

}
