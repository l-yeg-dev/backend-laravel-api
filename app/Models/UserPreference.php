<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'authors', 'categories', 'sources'
    ];

    protected $casts = [
        'authors' => 'array',
        'categories' => 'array',
        'sources' => 'array'
    ];

    function getRelations(): array
    {
        return [
            'sources' => Source::whereIn('id', $this->sources)->get(),
            'authors' => Author::whereIn('id', $this->authors)->get(),
            'categories' => Category::whereIn('id', $this->categories)->get()
        ];
    }
}
