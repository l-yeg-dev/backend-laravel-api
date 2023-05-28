<?php

namespace App\Services\NewsFetchers;

use GuzzleHttp\Client;
use App\Services\NewsFetchers\NewsFetcherInterface;

class NewsAPIFetcher implements NewsFetcherInterface
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetch()
    {
        $result = [];
        $apiKey = config('news.news_api.key');
        $apiBaseUrl = config('news.news_api.base_url');

        if (!$apiKey) {
            throw new \Error('NewsApi api key not provided');
        }

        $queryParams = [
            'apiKey' => $apiKey,
            'from' => '2023-04-28',
            'q' => 'crypto',
            'sortBy' => 'publishedAt'
        ];

        $response = $this->httpClient->get("$apiBaseUrl/v2/everything", ['query' => $queryParams]);
        $newsData = json_decode($response->getBody(), true);
        $articles = $newsData['articles'];

        foreach ($articles as $article) {
            $result[] = [
                'title' => $article['title'],
                'description' => $article['description'],
                'content' => $article['content'],
                'author' => $article['author'],
                'source' => isset($article['source']) ? $article['source']['name'] : null,
                'url' => $article['url'],
                'image_url' => $article['urlToImage'],
                'published_at' => $article['publishedAt'],
            ];
        }

        return $result;
    }
}
