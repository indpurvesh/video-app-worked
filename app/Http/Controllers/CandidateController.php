<?php

namespace App\Http\Controllers;

use App\Services\VideoService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    protected VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function myaccount() {
        return view('candidate.my-account');
    }

    public function upload() {
        return view('candidate.upload');
    }

    public function recording() {
        return view('candidate.recording');
    }


    public function index(Request $request)
    {
        $userId = $request->get('user_id', 1);
        $videos = $this->videoService->getVideos($userId);

        // dd($videos);
        return view('candidate.index-bk')
            ->with('videos', $videos);
    }
}
