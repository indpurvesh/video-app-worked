<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;



//### API VIDEO ROUTES
Route::get("/api/video", [VideoController::class, 'index'])->name('api.video.list');
Route::post("/api/video/upload", [VideoController::class, 'upload'])->name('api.video.upload');

Route::delete("/api/video/{videoId}", [VideoController::class, 'delete'])->name('api.video.delete');



//### WEB ROUTES
Route::get('/my-video', [CandidateController::class, 'index'])->name('my-video');

Route::get('/account/recording', [CandidateController::class, 'recording'])->name('recording');
Route::get('/account/upload', [CandidateController::class, 'upload'])->name('upload');

Route::get('/my-account', [CandidateController::class, 'myaccount']);



Route::get('/', function () {
    return view('welcome');
});
