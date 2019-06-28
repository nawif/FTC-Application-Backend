<?php
namespace App\Service\AuthService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserTasks as UserResource;
class AuthServiceImp implements AuthServiceInterface
{
    public function login($credentials)
    {
        return auth()->attempt($credentials);
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        return auth()->refresh();
    }

    public function userInfo()
    {

        return new UserResource(auth()->user());
    }
    
}
