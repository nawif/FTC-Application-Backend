<?php
namespace App\Service\EventService;

interface EventServiceContract
{
    public function store($event_data);
    public function patchEvent($newEvent);
    public function getEvents();
    public function enrollInEvent($id);
    public function archiveEvent($id);
}
