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

    public function appendRow(string $sheetId, array $row, string $sheetName = 'Sheet1'): void
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
            $sheetName.'!A:E',
            $body,
            $params
        );
    }
}
