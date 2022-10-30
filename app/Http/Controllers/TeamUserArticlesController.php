<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;

class TeamUserArticlesController extends Controller
{
    public function show(int $teamId, int $userId): Response
    {
        try {
            if (auth()->user()->isAdmin() || auth()->user()->getAuthIdentifier() == $userId) {
                $team = Team::find($teamId);
                $user = User::find($userId);

                if (!$team instanceof Team || !$user instanceof User) {
                    return $this->notFound();
                }

                $teamIds = array_map(function($team) {
                    return $team['id'];
                }, auth()->user()->teams->toArray());

                if (!auth()->user()->isAdmin() && !in_array($team->id, $teamIds)) { // User does not belong to the team
                    return $this->unauthorized();
                }

                return $this->success($user->articles()->where('team_id', '=', $teamId)->get());
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error(
                $exception->getMessage()
            );
        }
    }
}
