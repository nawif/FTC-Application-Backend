<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Event extends JsonResource
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
            'name' => $this->name,
            'whatsapp_link' => $this->whatsapp_link,
            'leader_id' => $this->leader_id,
            'is_leader' => Auth::user()->id == $this->leader_id,
            'description' => $this->description,
            'user_limit' => $this->user_limit,
            'date' => $this->date,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
