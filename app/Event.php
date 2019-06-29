<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'whatsapp_link', 'leader_id', 'description', 'user_limit', 'date', 'status', 'type',
    ];


    public function users()
    {
        return $this->belongsToMany('App\User','users_events');
    }

    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }
}
