<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialmediaAccount extends Model
{
    protected $fillable = [
        'platform', 'username', 'user_id'
    ];
}
