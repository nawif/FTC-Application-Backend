<?php

namespace App\Http\Resources;

use App\Http\Resources\SocialMedia as SocialMediaResource;

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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'student_id' => $this->student_id,
            'is_admin' => $this->is_admin,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'profilephoto_full_link' => $this->getProfilePhotoLink(),
            'profilephoto_b64' => $this->profilephoto,
            'total_points' => $this->total_points,
            'weekly_points' => $this->getWeekPoints(),
            'socialmedia' => SocialMediaResource::collection($this->socialMediaAccounts()->get())
        ];
    }
}
