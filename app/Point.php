<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'value', 'description', 'is_approved_by_admin', 'is_approved_by:leader', 'event_id', 'job_approved_by',
    ];
}
