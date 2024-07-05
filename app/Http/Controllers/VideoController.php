<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUploadRequest;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
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
        $userId = auth()->user()->id;
        
       
        $fileName = $request->file("video")->store('videos');
        
        $title = $request->get('title', 'Test video title');
       
        $videoModel = $this->videoService->uploadVideo($userId, $title, $fileName);

        return $videoModel;
    }
}
