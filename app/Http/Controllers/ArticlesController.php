<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticlesController\StoreRequest;
use App\Models\Article;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ArticlesController extends Controller
{
    public function index(): Response
    {
        try {
            return response([
                'status' => ResponseAlias::HTTP_OK,
                'success' => true,
                'data' => Article::all()
            ]);
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }

    public function show(int $articleId): Response
    {
        try {
            $article = Article::find($articleId);
            $status = $article != null ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_NOT_FOUND;

            return response(
                [
                    'status' => $status,
                    'success' => $article != null,
                    'data' => $article
                ],
                $status
            );
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }

    public function store(StoreRequest $request): Response {
        try {
            $article = Article::createFromDTO($request->getDTO());

            return response(
                [
                    'status' => ResponseAlias::HTTP_CREATED,
                    'success' => true,
                    'data' => $article
                ],
                ResponseAlias::HTTP_CREATED,
                ['location' => '/articles/' . $article->id]
            );
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }

    public function update(int $articleId, StoreRequest $request): Response {
        try {
            $article = Article::find($articleId);

            if (!$article instanceof Article) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            Article::updateFromDTO($article, $request->getDTO());

            return $this->success();
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }

    public function destroy(int $articleId): Response
    {
        try {
            $article = Article::find($articleId);

            if (!$article instanceof Article) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            $article->delete();
            return $this->success();

        } catch (Exception $exception) {
            return $this->internalError();
        }
    }
}
