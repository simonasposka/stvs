<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;

class BlogsController extends Controller
{
    public function index(): Collection
    {
        return Blog::with([
            'articles' => function($query) {
                return $query->with(['author', 'categories', 'comments']);
            }
        ])->get();
    }

    public function show(Blog $blog): Blog
    {
        return $blog;
    }
}
