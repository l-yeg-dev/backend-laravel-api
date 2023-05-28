<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Author, Category, Source};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PreferenceController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getPreferences()
    {
        $preferences = auth('sanctum')->user()?->preferences;

        return response()->json([
            'preferences' => $this->generatePreferencesOutput($preferences)
        ]);
    }

    public function setPreferences(Request $request)
    {

        $this->validate($request, [
            'sourceIds.*' => 'exists:sources,id',
            'categoryIds.*' => 'exists:categories,id',
            'authorIds.*' => 'exists:authors,id',
        ]);

        $authUser = auth('sanctum')->user();

        $sourceIds = $request->get('sourceIds', []);
        $categoryIds = $request->get('categoryIds', []);
        $authorIds = $request->get('authorIds', []);

        $preferences = $authUser->preferences;
        if ($preferences) {
            $preferences->sources = $sourceIds;
            $preferences->categories = $categoryIds;
            $preferences->authors = $authorIds;
            $preferences->save();
        } else {
            $preferences = $authUser->preferences()
                ->create([
                    'sources' =>  $sourceIds,
                    'categories' =>  $categoryIds,
                    'authors' =>  $authorIds,
                ]);
        }

        return response()->json([
            'preferences' => $this->generatePreferencesOutput($preferences)
        ]);
    }

    private function generatePreferencesOutput($preferences)
    {
        $preferredSources = $preferences ? implode(',', $preferences->sources) : null;
        $preferredAuthors = $preferences ? implode(',', $preferences->authors) : null;
        $preferredCategories = $preferences ? implode(',', $preferences->categories) : null;

        $sources = Source::select([
            '*',
            $preferredSources
                ? DB::raw("IF (id IN ($preferredSources), true, false) as selected")
                : DB::raw('false as selected')
        ])->get();

        $authors = Author::select([
            '*',
            $preferredAuthors
                ? DB::raw("IF (id IN ($preferredAuthors), true, false) as selected")
                : DB::raw('false as selected')
        ])->get();

        $categories = Category::select([
            '*',
            $preferredCategories
                ? DB::raw("IF (id IN ($preferredCategories), true, false) as selected")
                : DB::raw('false as selected')
        ])->get();

        return [
            'sources' => $sources,
            'authors' => $authors,
            'categories' => $categories,
        ];
    }
}
