<?php

return [
    'news_api' => [
        'base_url' => 'https://newsapi.org',
        'key' => env('NEWS_ORG_API_KEY'),
    ],
    'nyt' => [
        'base_url' => 'https://api.nytimes.com',
        'key' => env('NEW_YORK_TIMES_API_KEY'),
    ],
    'the_guardian' => [
        'base_url' => 'https://content.guardianapis.com',
        'key' => env('THE_GUARDIAN_API_KEY'),
    ]
];
