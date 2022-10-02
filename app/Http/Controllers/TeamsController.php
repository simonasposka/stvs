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
                'data' => Team::all() // should list only teams I own/belong to
            ]);
        } catch (Exception $exception) {
            return $this->error();
        }
    }

    public function show(int $teamId): Response
    {
        try {
            $team = Team::find($teamId);
            $status = $team != null ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_NOT_FOUND;

            return response(
                [
                    'status' => $status,
                    'success' => $team != null,
                    'data' => $team
                ],
                $status
            );
        } catch (Exception $exception) {
            return $this->error();
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

            Team::updateFromDTO($team, $request->getDTO());

            return $this->success();
        } catch (Exception $exception) {
            return $this->error();
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

            $team->delete();
            return $this->success();

        } catch (Exception $exception) {
            return $this->error();
        }
    }
}
