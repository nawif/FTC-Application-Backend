<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEvent;

class EventController extends Controller
{
    public function store(StoreEvent $request )
    {
        $validatedData = $request->validated();
        $validatedData['leader_id'] = Auth::user()->id;
        $event = new Event($validatedData);
        $event->save();
        $event->users()->attach($validatedData['registered_users']);
        return Response(["message" => "event ".$event->name." created successfully"], 201);
    }
}
