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
        return asset(Storage::url($this->getPath()));
    }

    public function getPath()
    {
        return $this->pathToFolder . $this->user_id .'.'. $this->extension;
    }

    public function moveToApproved()
    {
        $approvedPath= 'public/users_images/approved/'. $this->user_id .'.'. $this->extension;
        if(Storage::exists($approvedPath))
            Storage::delete($approvedPath);
        Storage::move($this->getPath(),$approvedPath);
    }

    public function deleteFile()
    {
        Storage::delete($this->getPath());
    }
}
