<?php

namespace App\Services\NewsFetchers;

use GuzzleHttp\Client;
use App\Services\NewsFetchers\NewsFetcherInterface;

class NewYorkTimesFetcher implements NewsFetcherInterface
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetch()
    {
        $result = [];
        $apiKey = config('news.nyt.key');
        $apiBaseUrl = config('news.nyt.base_url');

        if (!$apiKey) {
            throw new \Error('New York Times api key not provided');
        }

        $queryParams = [
            'api-key' => $apiKey
        ];

        $response = $this->httpClient->get("$apiBaseUrl/svc/news/v3/content/nyt/business.json", ['query' => $queryParams]);
        $newsData = json_decode($response->getBody(), true);
        $articles = $newsData['results'];

        foreach ($articles as $article) {
            $result[] = [
                'title' => $article['title'],
                'description' => $article['abstract'],
                'category' => $article['section'],
                'content' => $article['abstract'],
                'author' => $article['kicker'],
                'source' => isset($article['source']) ? $article['source'] : null,
                'url' => $article['url'],
                'image_url' => $article['thumbnail_standard'],
                'published_at' => $article['published_date'],
            ];
        }

        return $result;
    }
}
