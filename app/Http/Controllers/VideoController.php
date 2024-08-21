<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUploadRequest;
use App\Services\UserService;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    protected VideoService $videoService;
    protected UserService $userService;

    public function __construct(VideoService $videoService, UserService $userService)
    {
        $this->videoService = $videoService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        if ($request->get('type') === 'featured') 
        {
            return $this->videoService->getFeaturedVdieos($request->get('no_of_video', 1)); 
        }

        $userId = $request->get('user_id', 1);
        return $this->videoService->getVideos($userId);
    }

    public function saveFeatured($videoId) 
    {
        return $this->videoService->saveFeatured($videoId);
    }

    public function upload(VideoUploadRequest $request)
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
        $model = $this->uploadVideo(($request));
        return $model;
    }
    public function formupload(VideoUploadRequest $request)
    {
        $model = $this->uploadVideo(($request));
        return redirect()->route("my-video");
    }

    public function delete(string $videoId, Request $request)
    {
        $this->videoService->deleteVideo($videoId);

        return new JsonResponse();
    }

    private function uploadVideo(VideoUploadRequest $request) 
    {
        $userId = Auth::user()->id;
        
       
        $fileName = $request->file("video")->store('videos');
        
        $title = $request->get('title', 'Test video title');
       
        $videoModel = $this->videoService->uploadVideo($userId, $title, $fileName);

        return $videoModel;
    }
}
