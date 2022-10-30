<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Response;

class PublicArticlesController extends Controller
{
    public function index(): Response
    {
        try {
            return $this->success(Article::all());
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
