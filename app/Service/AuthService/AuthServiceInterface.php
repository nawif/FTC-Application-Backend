<?php
namespace App\Service\AuthService;
interface AuthServiceInterface
{
    public function login($credentials);
    public function logout();
    public function refresh();
    public function userInfo();
}