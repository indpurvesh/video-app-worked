<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    protected VideoService $videoService;
    protected UserService $userService;

    public function __construct(VideoService $videoService, UserService $userService)
    {
        $this->videoService = $videoService;
        $this->userService = $userService;
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
        $userId = auth()->user()->id;

        // only perform below in the event of no session
        if (null === $userId) {

            $userId = $request->get('candidateid');
            if (null !== $userId) {
                $this->userService->authCandidate($userId);
            }
    
    
            $userId = $request->get('employerid');
            if (null !== $userId) {
                $this->userService->authEmployer($userId);
            }
    
        }
          

        $videos = $this->videoService->getVideos($userId);

        return view('candidate.index-bk')
            ->with('videos', $videos);
    }

    public function getFeatured(Request $request) {
        return $this->videoService->getFeaturedVdieos($request->get('no', 1));
    }

    public function saveFeatured($videoId) 
    {
        return $this->videoService->saveFeatured($videoId);
    }
}
