<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleItemResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->description,
            'url' => $this->url,
            'imageUrl' => $this->image_url,
            'author' => $this->author,
            'source' => $this->source,
            'category' => $this->category,
            'publishedAt' => $this->published_at
        ];
    }
}
