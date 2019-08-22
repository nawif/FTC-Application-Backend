<?php
namespace App\Service\TaskService;

interface TaskServiceContract
{
    // public function store($user_data);
    public function getEventUnapprovedTasks($event_id);
}
