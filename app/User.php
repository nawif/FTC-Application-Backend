<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function points()
    {
        return $this->hasMany('App\Point');
    }

    public function unapprovedImages()
    {
        return $this->hasMany('App\UnapprovedImage');
    }

    public function events()
    {
        return $this->belongsToMany('App\Role');
    }

    public function socialMediaAccounts()
    {
        return $this->hasMany('App\SocialmediaAccount');
    }

    public function TotalPoints()
    {
        return $this->belongsTo('App\TotalPoints');
    }

    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }

}
