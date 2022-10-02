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

            return response(
                [
                    'status' => ResponseAlias::HTTP_OK,
                    'success' => true,
                    'data' => $team->users
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->error();
        }
    }

    public function update(int $teamId, UpdateRequest $request): Response
    {
        try {
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

            $team->users()->syncWithoutDetaching([$request->getDTO()->getUserId()]);
            return $this->success();
        } catch (Exception $exception) {
            return $this->error();
        }
    }

    public function destroy(int $teamId, int $userId): Response
    {
        try {
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

            $team->users()->detach([$userId]);
            return $this->success();
        } catch (Exception $exception) {
            return $this->error();
        }
    }
}
