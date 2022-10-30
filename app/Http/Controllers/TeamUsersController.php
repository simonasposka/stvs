<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUsersController\UpdateRequest;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TeamUsersController extends Controller
{
    public function show(int $teamId): Response
    {
        try {
            $myTeams = auth()->user()->teams;

            $teamIds = array_map(function($team) {
                return $team['id'];
            }, $myTeams->toArray());

            if (!in_array($teamId, $teamIds)) {
                return $this->unauthorized();
            }

            $team = Team::find($teamId);

            return response(
                [
                    'status' => ResponseAlias::HTTP_OK,
                    'success' => true,
                    'data' => $team->users
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function update(int $teamId, UpdateRequest $request): Response
    {
        try {
            $userId = $request->getDTO()->getUserId();

            if (auth()->user()->getAuthIdentifier() != $userId) {
                return $this->unauthorized();
            }

            $team = Team::find($teamId);
            if (!$team instanceof Team) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            $team->users()->syncWithoutDetaching([$userId]);
            return $this->success();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function destroy(int $teamId, int $userId): Response
    {
        try {
            if (auth()->user()->getAuthIdentifier() != $userId) {
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
            }, $user->teams->toArray());

            if (!auth()->user()->isAdmin() && !in_array($team->id, $teamIds)) { // User does not belong to the team
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            $team->users()->detach([$userId]);
            return $this->success();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
