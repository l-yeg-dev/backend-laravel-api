<?php

namespace App\Services\NewsFetchers;

use GuzzleHttp\Client;
use App\Services\NewsFetchers\NewsFetcherInterface;

class TheGuardiansFetcher implements NewsFetcherInterface
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetch()
    {
        $result = [];
        $apiKey = config('news.the_guardian.key');
        $apiBaseUrl = config('news.the_guardian.base_url');

        if (!$apiKey) {
            throw new \Error('The Guardian api key not provided');
        }

        $queryParams = [
            'api-key' => $apiKey,
            'format' => 'json',
            'from-date' => '2022-01-01',
            'show-tags' => 'contributor',
            'show-fields' => 'headline,thumbnail,short-url,body'
        ];

        $response = $this->httpClient->get("$apiBaseUrl/search", ['query' => $queryParams]);
        $newsData = json_decode($response->getBody(), true);
        $articles = $newsData['response']['results'];

        foreach ($articles as $article) {
            $result[] = [
                'title' => $article['webTitle'],
                'description' => $article['fields']['headline'],
                'content' => $article['fields']['body'],
                'url' => $article['fields']['shortUrl'],
                'image_url' => isset($article['fields']['thumbnail']) ? $article['fields']['thumbnail'] : null,
                'category' => $article['sectionName'],
                'author' => count($article['tags']) ? $article['tags'][0]['webTitle'] : null,
                'source' => "The Guardian",
                'published_at' => $article['webPublicationDate'],
            ];
        }

        return $result;
    }
}
