<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LineNotifyService
{
    protected ?string $token;

    public function __construct()
    {
        $this->token = config('services.line_notify.token') ?? null;
    }

    public function send(string $message): bool
    {
        if (!$this->token) return false;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->asForm()->post('https://notify-api.line.me/api/notify', [
                'message' => $message,
            ]);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}