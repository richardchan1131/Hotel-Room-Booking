<?php

namespace Modules\Ai\Drivers;

use Illuminate\Support\Facades\Http;
use Modules\Ai\Exceptions\APIReachLimit;
use Modules\Ai\Exceptions\DriverNotReady;

class OpenAi extends AiDriver
{
    protected $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function generate($message, $options = [])
    {
        if (!$this->isEnable()) {
            throw new DriverNotReady();
        }
        $json = $this->call($message, $options)->json();
        if (!empty($json['error']['message'])) {
            throw new \Exception($json['error']['message']);
        }
        $message = $json['choices'][0]['message']['content'];
        return trim($message, '"');
    }

    protected function call($message, $options = [])
    {
        return Http::withHeaders([
            'Content-Type'  => 'application/json',
            "Authorization" => "Bearer " . $this->settings['api_key']
        ])->post($this->endpoint, [
            'model'       => $this->settings['model'],
            'temperature' => $this->settings['temperature'] ?? 1,
            'max_tokens'  => $this->settings['max_tokens'] ?? 2048,
            "messages"    => [
                [
                    "role"    => "user",
                    "content" => $message
                ]
            ],
            ...$options
        ]);
    }

    public function isEnable()
    {
        return !empty($this->settings['api_key']) and !empty($this->settings['model']);
    }
}
