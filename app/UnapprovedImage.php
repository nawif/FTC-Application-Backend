<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UnapprovedImage extends Model
{
    protected $pathToFolder = 'public/users_images/pending/';
    protected $fillable = [
        'user_id', 'status', 'extension'
    ];
    // STATUS = PENDING, APPROVED, DENIED

    public function getURL()
    {
        return Storage::url($this->pathToFolder . $this->user_id . $this->extension);
    }
}
