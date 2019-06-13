<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;
use App\Http\Requests\StoreWork;
use App\Point;
use Illuminate\Http\Response;
use App\Event;

class PointController extends Controller
{
    public function store(StoreWork $request) {
        $user = auth()->user();

        Point::create([
            'user_id' => $user->id,
            'event_id' => $request['event_id'],
            'description' => $request['description']
            ]);

        return Response(['message' => 'work recorded!'], 201);
    }

    public function getEventPendingWork($event_id)
    {
        try {
            $event = Event::findOrfail($event_id);
        } catch (\Throwable $th) {
            return Response(['message' => 'no such event!'],422);
        }
        dd($event->points());


    }
}
