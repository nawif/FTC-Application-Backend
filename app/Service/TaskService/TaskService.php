<?php
namespace App\Service\TaskService;

use App\Service\TaskService\TaskServiceContract;
use App\Event;
use App\User;
use App\Task;
use App\Http\Resources\EventUnapprovedTasks;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\UserLeaderbaord as UserResource;
use App\Http\Resources\Event as EventResource;

class TaskService implements TaskServiceContract{

    public function getEventUnapprovedTasks($event_id){
        $user = Auth::user();
        $event = Event::where([['leader_id', $user->id], ['id', $event_id]])->first();
        if(!$event)
            return null;
        $response['event'] = new EventResource($event);
        // dd($response);
        $response['unapproved_work'] = $this->getEventPendingWork($event);
        return ($response);
    }

    private function getEventPendingWork($event){
        $eventUsersTasks = [];
        $users_ids = $event->unapprovedTasks()->groupBy('user_id')->pluck('user_id')->toArray();
        $i = 0;
        foreach ($users_ids as $user_id) {
            $user = User::find($user_id);
            $userEventTasks = Task::where([ ['user_id', $user_id], ['event_id', $event->id], ['is_approved', 0] ])->get();
            if(!$userEventTasks->toArray())
                continue;
            $userEventTasks = TaskResource::collection($userEventTasks);
            $eventUsersTasks [$i]['user']= new UserResource($user);
            $eventUsersTasks [$i]['tasks']= $userEventTasks;
            $i++;
        }

        return $eventUsersTasks;
    }

    public function getRecordedTasks(){ //TODO:
        $unapprovedTasksEventsIDs = Task::where('is_approved', 0)->get('id')->toArray();
        $events = Event::whereIn('id', $unapprovedTasksEventsIDs)->get();
        $eventsWithTasks = EventUnapprovedTasks::collection($events);
        return ($eventsWithTasks);
    }

}
