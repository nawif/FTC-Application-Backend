<?php
namespace App\Service\UserService;

interface UserServiceContract
{
    public function store($user_data);
    public function patch($user_data);
    public function addUnapprovedImage($image_request);
}
