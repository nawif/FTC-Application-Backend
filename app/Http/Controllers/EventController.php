<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Service\EventService\EventServiceContract;
use App\Event;
use App\Http\Resources\EventDetails as EventDetailsResources;


class EventController extends Controller
{
    public function store(StoreEvent $request, EventServiceContract $eventService ) {
        $validatedData = $request->validated();
        $event = $eventService->store($validatedData);
        return Response(["message" => "event ".$event->name." created successfully"], 201);
    }

    public function getEvents(EventServiceContract $eventService) {
        $eventsResource = $eventService->getEvents();
        return Response($eventsResource, 200);
    }

    public function getEventDetails($id) {
        try{
            $event = Event::findOrfail($id);
        } catch (\Throwable $th) {
            return Response(['message' => "event doesn't exist"], 422);
        }
        return Response(new EventDetailsResources($event), 200);
    }

    public function enrollInEvent($id, EventServiceContract $eventService) {
        $eventService->enrollInEvent($id);
    }
}
