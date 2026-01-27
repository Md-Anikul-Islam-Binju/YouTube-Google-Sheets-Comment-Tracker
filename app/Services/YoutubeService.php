<?php

namespace App\Services;

use Google\Client;
use Google\Service\YouTube;

class YoutubeService
{
    protected YouTube $service;

    public function __construct()
    {
        $client = new Client();
        $client->setDeveloperKey(config('services.youtube.key'));
        $this->service = new YouTube($client);
    }

    public function getLiveChatId(string $videoId): ?string
    {
        $res = $this->service->videos->listVideos(
            'liveStreamingDetails',
            ['id' => $videoId]
        );

        return $res[0]->liveStreamingDetails->activeLiveChatId ?? null;
    }

    public function getMessages(string $chatId, ?string $pageToken = null)
    {
        return $this->service->liveChatMessages->listLiveChatMessages(
            $chatId,
            'snippet,authorDetails',
            [
                'pageToken' => $pageToken,
                'maxResults' => 200
            ]
        );
    }
}
