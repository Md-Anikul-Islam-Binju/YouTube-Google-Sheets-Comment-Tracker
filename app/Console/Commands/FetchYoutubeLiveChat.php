<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YoutubeService;
use App\Services\GoogleSheetService;
use App\Models\YoutubeSetting;
use App\Models\ProcessedComment;

class FetchYoutubeLiveChat extends Command
{
    protected $signature = 'youtube:fetch';
    protected $description = 'Fetch YouTube live chat and push to Google Sheet';

    public function __construct(
        protected YoutubeService $youtube,
        protected GoogleSheetService $sheetService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $settings = YoutubeSetting::where('is_active', 1)->get();

        foreach ($settings as $setting) {

            if (!$setting->live_chat_id) {
                $setting->live_chat_id = $this->youtube->getLiveChatId($setting->video_id);
                $setting->save();
            }

            if (!$setting->live_chat_id) {
                $this->warn("No live chat for {$setting->video_id}");
                continue;
            }

            $response = $this->youtube->getMessages(
                $setting->live_chat_id,
                $setting->page_token
            );

            foreach ($response->items as $item) {

                foreach ($setting->keywords as $kw) {
                    if (preg_match("/\b$kw\s+(\d+)/i", $item->snippet->displayMessage, $m)) {

                        if (!ProcessedComment::where('comment_id', $item->id)->exists()) {

                            $this->sheetService->appendRow(
                                $setting->sheet_id,
                                [
                                    now()->toDateTimeString(),
                                    $item->authorDetails->displayName,
                                    $item->snippet->displayMessage,
                                    $kw,
                                    $m[1]
                                ]
                            );

                            ProcessedComment::create([
                                'comment_id' => $item->id,
                                'video_id' => $setting->video_id
                            ]);
                        }
                    }
                }
            }

            $setting->page_token = $response->nextPageToken ?? null;
            $setting->save();
        }

        $this->info('Fetch completed at '.now());
    }
}
