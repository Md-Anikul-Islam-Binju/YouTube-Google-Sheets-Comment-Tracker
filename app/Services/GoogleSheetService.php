<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetService
{
    protected ?Sheets $service = null;

    protected function getService(): Sheets
    {
        if ($this->service === null) {
            $client = new Client();
            $client->setApplicationName('YouTube Live Comment Tracker');
            $client->setScopes([Sheets::SPREADSHEETS]);

            $path = storage_path('app/google/service-account.json');

            if (!file_exists($path)) {
                throw new \Exception('Google service account JSON not found at: ' . $path);
            }

            $client->setAuthConfig($path);
            $client->setAccessType('offline');

            $this->service = new Sheets($client);
        }

        return $this->service;
    }

    /**
     * Append a row to Google Sheet
     */
    public function appendRow(string $sheetId, array $row): void
    {
        $service = $this->getService();

        $body = new ValueRange([
            'values' => [$row],
        ]);

        $params = [
            'valueInputOption' => 'RAW',
            'insertDataOption' => 'INSERT_ROWS',
        ];

        $service->spreadsheets_values->append(
            $sheetId,
            'Sheet1!A:E',
            $body,
            $params
        );
    }
}


//namespace App\Services;
//
//use Google\Client;
//use Google\Service\Sheets;
//
//class GoogleSheetService
//{
//    protected Sheets $service;
//
//    public function __construct()
//    {
//        $client = new Client();
//        $client->setAuthConfig(config('app.google_credentials'));
//        $client->addScope(Sheets::SPREADSHEETS);
//
//        $this->service = new Sheets($client);
//    }
//
//    public function appendRow(string $sheetId, array $row)
//    {
//        $range = 'Sheet1!A:E';
//
//        $body = new \Google\Service\Sheets\ValueRange([
//            'values' => [$row]
//        ]);
//
//        $params = ['valueInputOption' => 'RAW'];
//
//        $this->service->spreadsheets_values->append(
//            $sheetId,
//            $range,
//            $body,
//            $params
//        );
//    }
//}

