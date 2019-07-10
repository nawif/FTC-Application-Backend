<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLeaderbaord extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'bio' => $this->bio,
            'profilephoto_b64' => $this->profilephoto,
            'total_points' => $this->total_points,
            'weekly_points' => $this->getWeekPoints(),
        ];
    }
}
