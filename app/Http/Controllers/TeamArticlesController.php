<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUsersController\UpdateRequest;
use App\Models\Team;
use App\Models\User;
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

            return response(
                [
                    'status' => ResponseAlias::HTTP_OK,
                    'success' => true,
                    'data' => $team->articles
                ],
                ResponseAlias::HTTP_OK
            );
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }
}
