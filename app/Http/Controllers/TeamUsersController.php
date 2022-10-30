<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUsersController\UpdateRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;

class TeamUsersController extends Controller
{
    public function show(int $teamId): Response
    {
        try {
            $teamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($teamId, $teamIds)) {
                $team = Team::find($teamId);
                return $this->success($team->users);
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error(
                $exception->getMessage()
            );
        }
    }

    // only admin can add user to the team
    public function update(int $teamId, UpdateRequest $request): Response
    {
        try {
            if (auth()->user()->isAdmin()) {
                $team = Team::find($teamId);

                if (!$team instanceof Team) {
                    return $this->notFound();
                }

                $team->users()->syncWithoutDetaching([$request->getDTO()->getUserId()]);
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    // only admin can remove user from the team
    public function destroy(int $teamId, int $userId): Response
    {
        try {
            if (auth()->user()->isAdmin()) {
                $team = Team::find($teamId);

                if (!$team instanceof Team) {
                    return $this->notFound();
                }

                $team->users()->detach([$userId]);
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
