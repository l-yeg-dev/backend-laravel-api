<?php

namespace App\Services;

use App\Models\{Article, Author, Category, Source};
use App\Services\NewsFetchers\NewsFetcherInterface;

class NewsAggregator
{
    protected $newsFetcher;

    public function __construct(NewsFetcherInterface $newsFetcher)
    {
        $this->newsFetcher = $newsFetcher;
    }

    public function fetchNews()
    {
        $result = $this->newsFetcher->fetch();
        $articles = [];

        foreach ($result as $item) {
            $insertData = [
                'title' => $item['title'],
                'description' => $item['description'],
                'content' => $item['content'],
                'url' => $item['url'],
                'image_url' => $item['image_url'],
                'published_at' => date('Y-m-d H:i:s', strtotime($item['published_at'])),
            ];
            if (isset($item['source']) && $item['source']) {
                $source = Source::firstOrCreate(['name' => $item['source']]);
                $insertData['source_id'] = $source->id;
            }
            if (isset($item['author']) && $item['author']) {
                $author = Author::firstOrCreate(['name' => $item['author']]);
                $insertData['author_id'] = $author->id;
            }
            if (isset($item['category']) && $item['category']) {
                $category = Category::firstOrCreate(['name' => $item['category']]);
                $insertData['category_id'] = $category->id;
            }


                try {
                    $isExist = Article::where(['title' => $insertData['title']])->first();
                    if (!$isExist) {
                        Article::insert($insertData);
                    }
                } catch (\Throwable $th) {
                        //...
                }
                }
            }
    }
