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
            if (auth()->user()->isAdmin()) {
                return $this->success(Article::all());
            }

            return $this->success(auth()->user()->articles);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function show(int $articleId): Response
    {
        try {
            $article = Article::find($articleId);

            if (!$article instanceof Article) {
                return $this->notFound();
            }

            $users = array_map(function($user) {
                return $user['id'];
            }, $article->team->users->toArray());


            if (auth()->user()->isAdmin() || in_array(auth()->user()->getAuthIdentifier(), $users)) {
                return $this->success($article->withoutRelations()->load('user'));
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function store(StoreRequest $request): Response {
        try {
            $teamId = $request->getDTO()->getTeamId();
            $myTeamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($teamId, $myTeamIds)) {
                $article = Article::createFromDTO(
                    auth()->user()->getAuthIdentifier(),
                    $request->getDTO()
                );

                return response(
                    [
                        'status' => ResponseAlias::HTTP_CREATED,
                        'success' => true,
                        'data' => $article
                    ],
                    ResponseAlias::HTTP_CREATED,
                    ['location' => '/articles/' . $article->id]
                );
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function update(int $articleId, StoreRequest $request): Response {
        try {
            $teamId = $request->getDTO()->getTeamId();
            $myTeamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($teamId, $myTeamIds)) {
                $article = Article::find($articleId);

                if (!$article instanceof Article) {
                    return $this->notFound();
                }

                Article::updateFromDTO($article, $request->getDTO());
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function destroy(int $articleId): Response
    {
        try {
            $article = Article::find($articleId);

            if (!$article instanceof Article) {
                return $this->notFound();
            }

            $myTeamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($article->team_id, $myTeamIds)) {
                $article->delete();
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
