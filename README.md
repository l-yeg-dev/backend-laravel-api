# Laravel app | News Aggregator

News aggregator api working with 3 news APIs: NewsAPI, New York Times and The Guardian.
To see the news in the Front-End first need to setup and FETCH all articles from APIs.

## Setup
### Requirements
- docker
- docker-compose
- composer
- php8.2
- Laravel required default php extensions

### Get-Started
```
$ git clone ...
$ cd backend-laravel-api
$ cp .env.example .env
$ composer install # install dependencies for sail
$ ./vendor/bin/sail up # run docker-compose up

DB-Setup

$ ./vendor/bin/sail artisan migrate # create tables
$ ./vendor/bin/sail artisan db:seed # seed with fake data

# Get articles from external api-s and store to DB
$ ./vendor/bin/sail artisan app:fetch-news


$ Server will start run on http://localhost
```
