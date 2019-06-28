<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialmediaAccount extends Model
{
    protected $socialMediaPlatforms = ['twitter', 'steam', 'whatsapp', 'linkedin', 'snapchat'];

    protected $fillable = [
        'platform', 'username', 'user_id'
    ];
}
