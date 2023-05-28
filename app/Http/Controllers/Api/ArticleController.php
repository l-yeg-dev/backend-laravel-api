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
        $authUser = auth('sanctum')->user();

        $categories = $request->has('category') ? [$request->get('category')] : [];
        $sources = $request->has('source') ? [$request->get('source')] : [];
        $authors = $request->has('author') ? [$request->get('author')] : [];

        $date = $request->get('date');
        $startDate = isset($date['startDate']) ? date($date['startDate']) : null;
        $endDate = isset($date['endDate']) ? date($date['endDate']) : null;

        $search = $request->get('search');

        // If user is authenticated but filter is selected take search by query filter 
        if ($authUser && $authUser->preferences) {
            $preferences = $authUser->preferences;
            if (!count($sources) && count($preferences->sources)) {
                $sources = $preferences->sources;
            }
            if (!count($authors) && count($preferences->authors)) {
                $authors = $preferences->authors;
            }
            if (!count($categories) && count($preferences->categories)) {
                $categories = $preferences->categories;
            }
        }

        $news = Article::with(['author', 'source', 'category'])
            ->when(count($categories), function ($q) use ($categories) {
                $q->whereIn('category_id', $categories);
            })
            ->when($sources, function ($q) use ($sources) {
                $q->whereIn('source_id', $sources);
            })
            ->when($authors, function ($q) use ($authors) {
                $q->whereIn('author_id', $authors);
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->where('created_at', '>', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->where('created_at', '<', $endDate);
            })
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhere('content', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%");
            })
            ->get();

        return response()->json([
            'news' => ArticleResource::collection($news)
        ]);
    }
}
