<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;



Route::get('/my-video', [CandidateController::class, 'index']);



Route::get('/', function () {
    return view('welcome');
});
