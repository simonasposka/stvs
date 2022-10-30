<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use App\Http\Requests\UsersController\StoreRequest;

class UsersController extends Controller
{
    public function index(): Response
    {
        try {
            return $this->success(User::all());
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function show(int $userId): Response
    {
        try {
            $user = User::find($userId);

            if (!$user instanceof User) {
                return $this->notFound();
            }

            return $this->success([
                'teams' => $user->teams,
                'articles' => $user->articles
            ]);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function update(int $userId, StoreRequest $request): Response
    {
        try {
            $user = User::find($userId);

            if (!$user instanceof User) {
                return $this->notFound();
            }

            User::updateFromDTO($user, $request->getDTO());

            return $this->success();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function destroy(int $userId): Response
    {
        try {
            $user = User::find($userId);

            if (!$user instanceof User) {
                return $this->notFound();
            }

            $user->delete();
            return $this->success();

        } catch (Exception $exception) {
            return $this->error(
                $exception->getMessage()
            );
        }
    }
}
