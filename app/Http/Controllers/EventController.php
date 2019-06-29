<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Service\EventService\EventServiceContract;

class EventController extends Controller
{
    public function store(StoreEvent $request, EventServiceContract $eventService )
    {
        $validatedData = $request->validated();
        $event = $eventService->store($validatedData);
        return Response(["message" => "event ".$event->name." created successfully"], 201);
    }

    public function getEvents(EventServiceContract $eventService)
    {
        $eventsResource = $eventService->getEvents();
        return Response($eventsResource, 200);
    }
}
