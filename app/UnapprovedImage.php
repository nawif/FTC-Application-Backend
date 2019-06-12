<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnapprovedImage extends Model
{
    protected $fillable = [
        'user_id', 'is_approved'
    ];
}
