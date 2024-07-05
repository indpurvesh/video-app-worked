<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;



//### API VIDEO ROUTES
// Route::get("/api/video", [VideoController::class, 'index'])->name('api.video.list');

// Route::post("/api/video-featuredcarousel/{videoId}", [VideoController::class, 'saveFeatured'])->name("save.featured");

// Route::post("/api/video/upload", [VideoController::class, 'upload'])->name('api.video.upload');
// Route::post('/api/video/formupload', [VideoController::class, 'formupload'])->name('api.video.formupload');

// Route::delete("/api/video/{videoId}", [VideoController::class, 'delete'])->name('api.video.delete');



//### WEB ROUTES
Route::get('/', [CandidateController::class, 'index'])->name('my-video');

Route::get('/account/recording', [CandidateController::class, 'recording'])->name('recording');
Route::get('/account/upload', [CandidateController::class, 'upload'])->name('upload');



// @todo delete this one if possible 
// 
Route::get('/video-featured', [CandidateController::class, 'getFeatured']);
Route::get('/save-video-featured/{videoId}', [CandidateController::class, 'saveFeatured']);

