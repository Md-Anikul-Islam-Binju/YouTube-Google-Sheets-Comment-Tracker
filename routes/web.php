<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\YoutubeSettingController;
use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

//Admin
Route::middleware('auth')->group(callback: function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/youtube-settings', [YoutubeSettingController::class,'index'])->name('youtube-settings.index');
    Route::post('/youtube-settings', [YoutubeSettingController::class,'store'])->name('youtube-settings.store');
    Route::put('/youtube-settings-update/{id}', [YoutubeSettingController::class, 'update'])->name('youtube-settings.update');
    Route::get('/youtube-settings-delete/{id}', [YoutubeSettingController::class, 'destroy'])->name('youtube-settings.destroy');


    Route::get('/test-sheet', function(GoogleSheetService $sheet){
        // আপনার Google Sheet ID
        $sheetId = '1twX1RGM6VB_fUVVgWTqJ0Nvb1lZJRrC8RV226m0v6z0';

        // Append a demo row
        $sheet->appendRow($sheetId, [
            now()->format('Y-m-d H:i:s'), // Timestamp
            'Demo User',                  // Username
            'sold 9',                     // Comment
            'sold',                       // Keyword
            9                             // Number
        ]);

        return 'Demo row added to Google Sheet successfully!';
    });


    Route::get('/test-youtube', function(GoogleSheetService $sheet){
        $sheetId = '1twX1RGM6VB_fUVVgWTqJ0Nvb1lZJRrC8RV226m0v6z0';

        $demoComments = [
            ['Demo User1', 'sold 5', 'sold', 5],
            ['Demo User2', 'buy 2', 'buy', 2],
            ['Demo User3', 'tnx 1', 'tnx', 1],
        ];

        foreach ($demoComments as $comment) {
            $sheet->appendRow($sheetId, [
                now()->format('Y-m-d H:i:s'), // Timestamp
                $comment[0], // Username
                $comment[1], // Comment
                $comment[2], // Keyword
                $comment[3], // Number
            ]);
        }

        return 'Demo comments pushed to Google Sheet!';
    });



});
require __DIR__.'/auth.php';
