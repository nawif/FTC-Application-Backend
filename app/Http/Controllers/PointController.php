<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\User;
use App\Http\Resources\UserTasks;
use App\Http\Resources\UserLeaderbaord;

class PointController extends Controller
{

    public function getLeaderboard(){
        $users = User::where('is_admin', 0)->get(); // Admins shouldn't appear in the leaderboard

        $leaderboard = UserLeaderbaord::collection($users);

        return new Response($leaderboard, 200);
    }

}
