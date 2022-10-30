<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TeamArticlesController extends Controller
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

            $myTeamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($teamId, $myTeamIds)) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_OK,
                        'success' => true,
                        'data' => $team->articles
                    ],
                    ResponseAlias::HTTP_OK
                );
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
