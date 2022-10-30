<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;

class SeedController extends Controller
{
    public function seed(): Response
    {
        try {
            // 1. Create two users: admin and simple
            $adminUser = User::createUser(1, 'admin@gmail.com', 'admin', 'testas', true);
            $simpleUser = User::createUser(2, 'simple@gmail.com', 'simple', 'testas', false);

            // 2. Create two teams;
            $team1 = Team::createTeam(1, $adminUser->id, 'team1', 'team1');
            $team2 = Team::createTeam(2, $simpleUser->id, 'team2', 'team2');

            // 3. Add users to teams
            $team1->users()->sync([$adminUser->id]);
            $team2->users()->sync([$simpleUser->id]);

            // 4. Create few articles
            $adminArticle1 = Article::createArticle(1, $adminUser->id, $team1->id, 'article1', 'article1');
            $simpleUserArticle1 = Article::createArticle(2, $simpleUser->id, $team2->id, 'article3', 'article3');

            return $this->success();
        } catch (Exception $exception) {
            return $this->error(
                $exception->getMessage()
            );
        }
    }

    // delete all records
    public function clear(): Response
    {
        try {
            User::whereNotNull('id')->delete();
            return $this->success();
        } catch (Exception $exception) {
            return $this->error(
                $exception->getMessage()
            );
        }
    }
}
