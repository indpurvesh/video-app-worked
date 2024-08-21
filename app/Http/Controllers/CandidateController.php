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

    public function SaveSuspend($userId) 
    {
        $this->userService->saveSuspend($userId);
    }

    public function SaveHired($userId)
    {
        $this->userService->saveHired($userId);
    }

    public function myaccount() {
        return view('candidate.my-account');
    }

    public function upload(Request $request) {
        $user = Auth::user();
        // only perform below in the event of no session
        if (null === $user) {

            $userId = $request->get('candidateid');
            if (null !== $userId) {
                $this->userService->authCandidate($userId);
            } elseif(null !== $request->get('employerid')) {
                $this->userService->authEmployer($request->get('employerid'));
            } else {
                throw new \Exception("id is required");
            }
        }

        return view('candidate.upload');
    }

    public function recording() {
        return view('candidate.recording');
    }

    public function index(Request $request)
    {   
        $user = Auth::user();
        // only perform below in the event of no session
        if (null === $user) {

            $userId = $request->get('candidateid');
            if (null !== $userId) {
                $this->userService->authCandidate($userId);
            } elseif(null !== $request->get('employerid')) {
                $this->userService->authEmployer($request->get('employerid'));
            } else {
                throw new \Exception("id is required");
            }
        }
        $user = Auth::user();
        $status = $request->get('status');
        $noOfVideos = $request->get('showvideos');
        $recordFlag = $request->get('record', null);
        $favorite = $request->get('employerfav', false);

        $videos = $this->videoService->getVideos($user->id, $status, $noOfVideos, $favorite);

        return view('candidate.index-bk')
            ->with('videos', $videos)
            ->with('recordFlag', $recordFlag);
    }

    public function getFeatured(Request $request) {
        return $this->videoService->getFeaturedVdieos($request->get('no', 1));
    }

    public function saveFeatured($videoId) 
    {
        return $this->videoService->saveFeatured($videoId);
    }
}
