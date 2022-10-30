<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TeamUserArticlesController extends Controller
{
    public function show(int $teamId, int $userId): Response
    {
        try {
            if (!auth()->user()->isAdmin() && auth()->user()->getAuthIdentifier() != $userId) {
                return $this->unauthorized();
            }

            $team = Team::find($teamId);
            $user = User::find($userId);

            if (!$team instanceof Team || !$user instanceof User) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            $teamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (!auth()->user()->isAdmin() && !in_array($team->id, $teamIds)) { // User does not belong to the team
                return $this->unauthorized();
            }

            return response(
                [
                    'status' => ResponseAlias::HTTP_OK,
                    'success' => true,
                    'data' => $user->articles()->where('team_id', '=', $teamId)->get()
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
