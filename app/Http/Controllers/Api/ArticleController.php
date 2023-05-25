<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{

    public function index(Request $request)
    {

        $news = Article::all();

        return response()->json([
            'news' => ArticleResource::collection($news)
        ]);
    }
}
