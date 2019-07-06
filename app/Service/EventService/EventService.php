<?php
namespace App\Service\EventService;

use App\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Event as EventResource;

class EventService implements EventServiceContract{

    public function store($event_data) {
        $event_data['leader_id'] = Auth::user()->id;
        $event = new Event($event_data);
        $event->save();
        if(array_key_exists('registered_users', $event_data)) // checks if registered_users exist
            $event->users()->attach(array_unique($event_data['registered_users'])); //array_unique removed duplicates
        return $event;
    }

    public function patchEvent($newEvent) {
        $user = Auth::user();

        $event = Event::Find($newEvent['id']);
        if($event->leader_id != $user->id)
            return Response(['message' => 'you can\'t patch this event'], 404);
        $event->update($newEvent);
        if(array_key_exists('registered_users', $event)) // checks if registered_users exist
            $event->users()->attach(array_unique($event['registered_users'])); //array_unique removed duplicates

        return Response(['message' => 'event patched'], 200);
    }

    public function archiveEvent($event_id){
        $user = Auth::user();

        $event = Event::find($event_id);
        if(!$event)
            return Response(['message' => 'no such event'], 404);
        if($event->leader_id != $user->id)
            return Response(['message' => 'you can\'t archive this event'], 404);

        $event->status='DONE';
        $event->save();
        return Response(['message' => 'event archived'], 200);
    }

    public function getEvents() {
        $user = Auth::user();

        $availableEvents = Event::where('status', 'READY')->get();
        $fullEvents = Event::where('status', 'FULL')->get();
        $userEvents =  $user->events()->get();

        //removing events where user already enrolled in
        $availableEvents= $availableEvents->whereNotIn('id' ,$userEvents->pluck('id'))->where('leader_id', '<>', $user->id);
        $fullEvents = $fullEvents->whereNotIn('id' ,$userEvents->pluck('id'));

        $events['available'] = EventResource::collection($availableEvents);
        $events['registered'] = EventResource::collection($userEvents);
        $events['full'] = EventResource::collection($fullEvents);

        return $events;
    }

    public function enrollInEvent($event_id){
        try { //checking if event exist
            $event = Event::findOrfail($event_id);
        } catch (\Throwable $th) {
            return Response(['message' => 'event doesn\'t exist '], 404);
        }
        //checking if event is full
        if($event->status == 'FULL'){
            return Response(['message' => 'event full'], 404);
        }
        $user = Auth::user();

        if (! $event->users->contains($user->id)) {
            $event->users()->save($user);
        }else
            return Response(['message' => 'user already enrolled'], 404);

        if($event->users->count() >= $event->user_limit){
            $event->status = 'FULL';
        }

        $event->save();

        return Response(['message' => 'user added'], 200);
    }
}
