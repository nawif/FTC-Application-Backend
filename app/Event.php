<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'whatsapp_link', 'leader_id', 'description', 'user_limit', 'date', 'status', 'type',
    ];
}
