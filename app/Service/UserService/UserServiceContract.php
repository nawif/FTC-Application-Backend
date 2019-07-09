<?php
namespace App\Service\UserService;

interface UserServiceContract
{
    public function store($user_data);
    public function patch($user_data);
    public function addUnapprovedImage($image);
    public function approveImage($is_approved, $user_id);
}
