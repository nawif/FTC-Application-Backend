<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class PendingImage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->id);
        return [
            'url' => $this->getURL(),
            'full_name' => $user->getFullName(),
            'id' => $user->id
        ];
    }
}
