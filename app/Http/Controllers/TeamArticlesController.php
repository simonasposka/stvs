<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Exception;
use Illuminate\Http\Response;

class TeamArticlesController extends Controller
{
    public function show(int $teamId): Response
    {
        try {
            $team = Team::find($teamId);

            if (!$team instanceof Team) {
                return $this->notFound();
            }

            $myTeamIds = array_map(function($team) {
                return $team['id'];
            }, auth()->user()->teams->toArray());

            if (auth()->user()->isAdmin() || in_array($teamId, $myTeamIds)) {
                return $this->success($team->articles);
            }

            return $this->unauthorized();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}
