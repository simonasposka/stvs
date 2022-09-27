<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticlesController extends Controller
{
    public function index(): Collection
    {
        return Article::all();
    }

    public function show(Article $article): array
    {
        return $article->load(['categories', 'comments'])->toArray();
    }
}
