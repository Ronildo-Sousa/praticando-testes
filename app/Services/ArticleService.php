<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function store(array $payload): Article
    {
        $payload['user_id'] = auth()->user()->id;
        $article = Article::create($payload);

        return $article;
    }
}
