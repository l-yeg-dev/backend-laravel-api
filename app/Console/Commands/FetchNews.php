<?php

namespace App\Console\Commands;

use App\Services\NewsAggregator;
use App\Services\NewsFetchers\{NewsAPIFetcher, NewYorkTimesFetcher, TheGuardiansFetcher};
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from various news sites';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $httpClient = new Client();

        // Would be good to use jobs
        $newsApiFetcher = new NewsAPIFetcher($httpClient);
        $newYorkTimesFetcher = new NewYorkTimesFetcher($httpClient);
        $theGuardianFetcher = new TheGuardiansFetcher($httpClient);

        foreach ([$newsApiFetcher, $newYorkTimesFetcher, $theGuardianFetcher] as $newsFetcher) {
            $newsAggregator = new NewsAggregator($newsFetcher);
            $newsAggregator->fetchNews();
        }
    }
}
