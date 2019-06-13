<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'value', 'approved_by_admin_id', 'task_id'
    ];

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

}
