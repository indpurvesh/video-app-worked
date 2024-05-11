<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Symfony\Component\HttpClient\Psr18Client;

class VideoController extends Controller
{
    protected VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }


    public function index(Request $request)
    {
       
        $userId = $request->get('user_id');
        return $this->videoService->getVideos($userId);
    }

    public function upload(Request $request)
    {
        $userId = $request->get('user_id');
        
       
        $fileName = $request->file("video")->store('videos');
        
        $title = $request->get('title', 'Test video title');
       
        $video  = $this->videoService->uploadVideo($userId, $title, $fileName);
    
       
        return $video;
        
    }

    public function delete(string $videoId, Request $request)
    {
        $this->videoService->deleteVideo($videoId);

        return new JsonResponse();
    }
}
