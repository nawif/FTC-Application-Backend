<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Event as EventResource;


class EventDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'event' => new EventResource($this),
            'leader' => new UserResource($this->leader()->first()),
            'users' => UserResource::collection($this->users()->get())
        ];
    }
}
