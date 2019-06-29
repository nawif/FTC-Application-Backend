<?php
namespace App\Service\EventService;

use App\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Event as EventResource;

class EventService implements EventServiceContract{

    public function store($event_data)
    {
        $event_data['leader_id'] = Auth::user()->id;
        $event = new Event($event_data);
        $event->save();
        if(array_key_exists('registered_users', $event_data)) // checks if registered_users exist
            $event->users()->attach(array_unique($event_data['registered_users'])); //array_unique removed duplicates
        return $event;
    }

    public function getEvents() {
        $user = Auth::user();

        $availableEvents = Event::where('status', 'READY')->get();
        $fullEvents = Event::where('status', 'FULL')->get();
        $userEvents =  $user->events()->get();

        //removing events where user already enrolled in
        $availableEvents= $availableEvents->whereNotIn('id' ,$userEvents->pluck('id'));
        $fullEvents = $fullEvents->whereNotIn('id' ,$userEvents->pluck('id'));

        $events['available'] = EventResource::collection($availableEvents);
        $events['registered'] = EventResource::collection($userEvents);
        $events['full'] = EventResource::collection($fullEvents);

        return $events;
    }

    private function canEnroll($user, $event){
        ($event);
    }
}
