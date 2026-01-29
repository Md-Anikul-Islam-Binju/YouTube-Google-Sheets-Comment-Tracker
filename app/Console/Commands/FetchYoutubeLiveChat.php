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
        // Active YouTube settings
        $settings = YoutubeSetting::where('is_active', 1)->get();

        foreach ($settings as $setting) {

            // 1️⃣ Fetch live chat ID if not already saved
            if (!$setting->live_chat_id) {
                $setting->live_chat_id = $this->youtube->getLiveChatId($setting->video_id);
                $setting->save();
            }

            if (!$setting->live_chat_id) {
                $this->warn("No live chat for video_id: {$setting->video_id}");
                continue;
            }

            // 2️⃣ Fetch live chat messages
            $response = $this->youtube->getMessages(
                $setting->live_chat_id,
                $setting->page_token
            );

            foreach ($response->items as $item) {
                $message = $item->snippet->displayMessage;

                // Loop through each keyword from DB
                foreach ($setting->keywords as $kw) {
                    $kw = trim($kw);                // remove spaces
                    $kw = preg_quote($kw, '/');     // escape regex special chars

                    // Match keyword optionally followed by a number
                    if (preg_match("/(^|\s)$kw(?:\s+(\d+))?/i", $message, $m)) {
                        $number = $m[2] ?? null; // number or null

                        // Skip if already processed
                        if (!ProcessedComment::where('comment_id', $item->id)->exists()) {

                            // Append row to Google Sheet
                            $this->sheetService->appendRow(
                                $setting->sheet_id,
                                [
                                    now()->toDateTimeString(),
                                    $item->authorDetails->displayName,
                                    $message,
                                    $kw,
                                    $number
                                ]
                            );

                            // Mark comment as processed in DB
                            ProcessedComment::create([
                                'comment_id' => $item->id,
                                'video_id' => $setting->video_id
                            ]);

                            $this->info("Processed: {$item->authorDetails->displayName} => $message");
                        }
                    }
                }
            }

            // 3️⃣ Save nextPageToken for pagination
            $setting->page_token = $response->nextPageToken ?? null;
            $setting->save();
        }

        $this->info('Fetch completed at '.now());
    }
}
