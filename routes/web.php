<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\YoutubeSettingController;
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

});
require __DIR__.'/auth.php';
