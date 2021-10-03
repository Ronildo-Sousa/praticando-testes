<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function index()
    {
        return response()->json(['articles' => Article::all()], Response::HTTP_OK);
    }

    public function store(StoreArticleRequest $request)
    {
        $newArticle = (new ArticleService())->store($request->validated());

        if ($newArticle) {
            return response()->json([
                'message' => 'Article created successfully',
                'data' => $newArticle
            ], Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Cannot create article.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
