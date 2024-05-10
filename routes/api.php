<?php

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get("/video", [VideoController::class, 'index'])->name('api.video.list');
Route::post("/video/upload", [VideoController::class, 'upload'])->name('api.video.upload');

Route::delete("/video/{videoId}", [VideoController::class, 'delete'])->name('api.video.delete');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
