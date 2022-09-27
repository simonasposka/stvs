<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TeamsController extends Controller
{
    public function index(): array
    {
//        /* @var $user User */
//        $user = auth()->user();
        return [
//            'owner' => $user->ownedTeams()->get(),
//            'teams' => []
        ];
    }
}
