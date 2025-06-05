<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $client;
    protected $apiKey;
    protected $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY');
    }

    /**
     * Generate a supportive message using Gemini.
     *
     * @param string $firstName
     * @param string $todayMood
     * @param array $weekMoods (associative: Mon => mood, ...)
     * @return string
     * @throws \Exception
     */
    public function generateSupportiveMessage($firstName, $todayMood, $weekMoods)
    {
        $weekMoodStr = collect($weekMoods)
            ->map(function($mood, $day) { return $day . ': ' . ($mood ?: 'none'); })
            ->implode(", ");

        $prompt = "You are a friendly vitality coach with a focus on mental health. Write a short, supportive, and positive message for a user named $firstName who selected the mood '$todayMood' today. Their moods for this week are: $weekMoodStr. Use their first name in the message. Be encouraging and empathetic. Keep the message concise (1-2 sentences). Do not use any Markdown, asterisks, underscores, or special formatting—write in plain text only. End the message with a friendly invitation for the user to share anything they'd like (problems, good news, or anything else), and make sure your suggestion for sharing is correctly related to their selected mood today.";

        $response = $this->client->post($this->endpoint, [
            'query' => ['key' => $this->apiKey],
            'json' => [
                'contents' => [
                    ['parts' => [ ['text' => $prompt] ]]
                ]
            ],
            'timeout' => 10,
        ]);

        $data = json_decode($response->getBody(), true);
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($data['candidates'][0]['content']['parts'][0]['text']);
        }
        throw new \Exception('No message from Gemini');
    }
}
