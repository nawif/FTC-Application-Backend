<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTask;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\UserTasks as UserTasksResource;

use App\User;
use Illuminate\Http\Response;

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
        Task::create([
            'description' => $request['description'],
            'user_id' => $user->id,
            'event_id' => $request['event_id'],
            ]);
        return Response(['message' => 'task created!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showUserTasks($user_id) {
        try {
            $user = User::findOrfail($user_id)->first();
        } catch (\Throwable $th) {
            return Response(['message' => 'no such user!'], 422);
        }
        $userTasks = new UserTasksResource($user);

        return new Response($userTasks, 200);
    }

        /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showEventUnapprovedTasks($event_id) {
        try {
            $event = Event::findOrfail($event_id);
        } catch (\Throwable $th) {
            return Response(['message' => 'no such event!'], 422);
        }
        $userTasks = $user->tasks()->get();
        $userTasks = TaskResource::collection($userTasks);

        return new Response($userTasks, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
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
