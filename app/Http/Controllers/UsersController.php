<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UsersController extends Controller
{
    public function index(): Response
    {
        try {
            return response([
                'status' => ResponseAlias::HTTP_OK,
                'success' => true,
                'data' => User::all()
            ]);
        } catch (Exception $exception) {
            return $this->internalError();
        }
    }

    public function destroy(int $userId): Response
    {
        try {
            $user = User::find($userId);

            if (!$user instanceof User) {
                return response(
                    [
                        'status' => ResponseAlias::HTTP_NOT_FOUND,
                        'success' => false,
                        'data' => null
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }

            $user->delete();
            return $this->success();

        } catch (Exception $exception) {
            return $this->internalError();
        }
    }
}
