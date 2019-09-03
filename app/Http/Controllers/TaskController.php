<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTask;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\UserTasks as UserTasksResource;

use App\User;
use Illuminate\Http\Response;
use App\Service\TaskService\TaskServiceContract;
use App\Event;
use App\Http\Requests\PatchTask;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request)
    {
        $user = auth()->user();
        foreach ($request['work'] as $description) {
            Task::create([
                'description' => $description,
                'user_id' => $user->id,
                'event_id' => $request['event_id'],
                'is_approved' => Event::find($request['event_id'])->leader_id == $user->id
                ]);
        }
        return Response(['message' => 'tasks created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showUserTasks($user_id) {
        try {
            $user = User::findOrfail($user_id);
        } catch (\Throwable $th) {
            return Response(['message' => 'no such user!'], 404);
        }
        $userTasks = new UserTasksResource($user);

        return new Response($userTasks, 200);
    }

    /**
     *
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showUnapprovedTasks($id, TaskServiceContract $taskService) {
        $eventsUnapprovedTasks = $taskService->getEventUnapprovedTasks($id);
        return new Response($eventsUnapprovedTasks, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PatchTask  $request
     * @return \Illuminate\Http\Response
     */

    public function update(PatchTask $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        if(Event::find($validatedData['event_id'])->leader_id != $user->id)
            return Response("UNAUTH", 404);

        foreach ($validatedData['tasks'] as $task) {
            try {
                $task_record = Task::where([
                    ['event_id', '=', $validatedData['event_id']],
                    ['id', '=', $task['id']]
                ])->firstOrFail();
            } catch (\Throwable $th) {
                return Response("UNAUTH", 404);
            }
            switch ($task['status']) {
                case 'approved':
                    $task_record->is_approved = 1;
                    $task_record->save();
                    break;
                case 'declined':
                    $task_record->is_approved = -1;
                    $task_record->save();
                    break;
                case 'edited':
                $task_record->is_approved = 1;
                $task_record->description = $task['description'];
                $task_record->save();
                    break;
            }
        }

        return Response("task updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
