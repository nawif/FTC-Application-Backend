<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'student_id', 'is_admin', 'phone', 'device_id', 'bio', 'profilephoto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getDefaultPhoto()
    {
        return "String"; //TODO:
    }

    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getTotalPoints()
    {
        return $this->totalPoints()->first()->value;
    }

    public function getProfilePhotoLink()
    {
        return "hello world";
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }


    public function unapprovedImages()
    {
        return $this->hasMany('App\UnapprovedImage');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event','users_events');
    }

    public function socialMediaAccounts()
    {
        return $this->hasMany('App\SocialmediaAccount');
    }

    public function totalPoints()
    {
        return $this->hasOne('App\TotalPoints');
    }

    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }

}
