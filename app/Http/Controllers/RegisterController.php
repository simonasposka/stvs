<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterController\StoreRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(StoreRequest $request): User
    {
        $dto = $request->getDTO();

        $user = new User();
        $user->name = $dto->getName();
        $user->email = $dto->getEmail();
        $user->password = Hash::make($dto->getPassword());
        $user->save();

        return $user;
    }
}
