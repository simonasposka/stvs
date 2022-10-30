<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamsController\StoreRequest;
use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TeamsController extends Controller
{
    public function index(): Response
    {
        try {
            return response([
                'status' => ResponseAlias::HTTP_OK,
                'success' => true,
                'data' => auth()->user()->teams
            ]);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

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
                    'success' => $team != null,
                    'data' => $team
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function store(StoreRequest $request): Response
    {
        try {
            $team = Team::createFromDTO($request->getDTO());

            return response(
                [
                    'status' => ResponseAlias::HTTP_CREATED,
                    'success' => true,
                    'data' => $team
                ],
                ResponseAlias::HTTP_CREATED,
                ['location' => '/teams/' . $team->id]
            );
        } catch (Exception $exception) {
            return $this->error();
        }
    }

    public function update(int $teamId, StoreRequest $request): Response
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

            if ($team->user_id === auth()->user()->getAuthIdentifier() || auth()->user()->isAdmin()) {
                Team::updateFromDTO($team, $request->getDTO());
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function destroy(int $teamId): Response
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

            if ($team->user_id === auth()->user()->getAuthIdentifier() || auth()->user()->isAdmin()) {
                $team->delete();
                return $this->success();
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
