<?php

namespace App\Services;

use ApiVideo\Client\Client;
use ApiVideo\Client\Model\Video as ApiVideo;
use ApiVideo\Client\Model\VideoCreationPayload;
use App\Models\Video;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Symfony\Component\HttpClient\Psr18Client;

class VideoService
{
    public function getVideos($userId): Collection 
    {
        $videos= Video::where('user_id', $userId)->get();

        return $videos;
    }

    public function uploadVideo($userId, $videoTitle , $videoPath)
    {
        $client = $this->getApiVideoClient();

        $payload = (new VideoCreationPayload())
            ->setTitle($videoTitle);
    
        $video = $client->videos()->create($payload);
        
        
        try {
            $videoModel = Video::create([
                'user_id' => $userId,
                'title' => $videoTitle, 
                'local_path' => $videoPath
            ]);
        
            $client->videos()->upload($video->getVideoId(), new SplFileObject(Storage::path($videoPath)));
            $videoModel->api_video_id = $video->getVideoId();
            $videoModel->player = $video->getAssets()->getPlayer();
            $videoModel->thumbnail = $video->getAssets()->getThumbnail();
            $videoModel->api_video_source = $video->getAssets()->getMp4();
    
            $videoModel->save();

        } catch (\Throwable $th) {
            $videoModel->delete();
            throw new Exception("there is an issue while uploading a video");
        }


        return $videoModel;
    }

    public function deleteVideo($videoId) 
    {
        $videoModel = Video::find($videoId);
        
      
        if ($videoModel == null || $videoModel->api_video_id == '') {
            throw new Exception("Video is missing");
        }
        $client = $this->getApiVideoClient();

        try {
            $client->videos()->delete($videoModel->api_video_id);
            Storage::delete($videoModel->local_path);
            $videoModel->delete();
        } catch (\Throwable $th) {
            throw new Exception("there is an issue while deleting a video");
        }
    }


    private function getApiVideoClient(): Client {
        $httpClient = new Psr18Client();
        $url = config('video.url');
        $apiKey = config('video.api_key');

        $client = new Client($url, $apiKey, $httpClient);

        return $client;
    }
}
