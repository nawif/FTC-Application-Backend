<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalPoints extends Model
{
    protected $fillable = [
        'user_id', 'value',
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
