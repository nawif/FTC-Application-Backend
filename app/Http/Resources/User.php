<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'student_id' => $this->student_id,
            'is_admin' => $this->is_admin,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'profilephoto_b64' => $this->profilephoto,
            'profilephoto_full_link' => $this->getProfilePhotoLink(),
            'total_points' => $this->totalPoints(),
        ];
    }
}
