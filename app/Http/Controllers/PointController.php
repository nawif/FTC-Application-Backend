<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\User;
use App\Http\Resources\UserTasks;

class PointController extends Controller
{

    public function getLeaderboard(){
        $users = User::where('is_admin', 0)->get(); // Admins shouldn't appear in the leaderboard

        $sortedUsers = $users->sortByDesc(function ($user) {
            return $user->getTotalPoints();
        });
        $sortedResource = UserTasks::collection($sortedUsers);

        return new Response($sortedResource, 200);

    }

}
