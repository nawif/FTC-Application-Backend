<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalPoints extends Model
{
    protected $fillable = [
        'value', 'user_id'
    ];
}
