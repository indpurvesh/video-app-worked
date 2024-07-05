<?php

namespace App\Services;

use ApiVideo\Client\Client;
use ApiVideo\Client\Model\Video as ApiVideo;
use ApiVideo\Client\Model\VideoCreationPayload;
use App\Models\Video;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Symfony\Component\HttpClient\Psr18Client;

class VideoService
{
    public function getVideos(int $userId): Collection 
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
            ]);
        
            $client->videos()->upload($video->getVideoId(), new SplFileObject(Storage::path($videoPath)));
            $videoModel->api_video_id = $video->getVideoId();
            $videoModel->player = $video->getAssets()->getPlayer();
            $videoModel->thumbnail = $video->getAssets()->getThumbnail();
            $videoModel->api_video_source = $video->getAssets()->getMp4();
    
            $videoModel->save();

        } catch (Exception $e) {
            Log::error("api upload video error: " . $e->getMessage());
            throw new Exception("there is an issue while uploading a video");
        }


        return $videoModel;
    }

    public function saveFeatured($videoId)
    {
        $video = Video::find($videoId);
        if (null === $video) {
            throw new Exception("no video found with given video Id");
        }

        $video->is_featured = true;
        $video->save();

        return $video;
    }

    public function getFeaturedVdieos(int $noOfVideo) {
        $videos = Video::where('is_featured', true)->paginate($noOfVideo);

        return $videos;
    }

    public function deleteVideo($videoId) 
    {
        $videoModel = Video::find($videoId);
        
      
        if ($videoModel == null || $videoModel->api_video_id == '') {
            throw new Exception("Video is missing");
        }
        $client = $this->getApiVideoClient();

        try {
            // $client->videos()->delete($videoModel->api_video_id);

            // @todo delete video from local folder
            // Storage::delete($videoModel->local_path);
            $videoModel->delete();
        } catch (Exception $e) {
            Log::error("delete video  " . $videoId . " error " . $e->getMessage());
            
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
