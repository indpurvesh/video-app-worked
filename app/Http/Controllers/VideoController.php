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
        $userId = $request->get('user_id', 1);
        return $this->videoService->getVideos($userId);
    }

    public function upload(VideoUploadRequest $request)
    {
        $userId = $request->get('user_id', 1);
        
       
        $fileName = $request->file("video")->store('videos');
        
        $title = $request->get('title', 'Test video title');
       
        $this->videoService->uploadVideo($userId, $title, $fileName);
    
       
        return redirect()->route("my-video");
        
    }

    public function delete(string $videoId, Request $request)
    {
        $this->videoService->deleteVideo($videoId);

        return new JsonResponse();
    }
}
