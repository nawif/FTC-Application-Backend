<?php

namespace App\Http\Controllers;

use App\Service\UserService\UserServiceContract;
use App\Http\Requests\StoreUser;
use Illuminate\Auth\Access\Response;


class UserController extends Controller
{

    public function store(StoreUser $request, UserServiceContract $userService ) {
        $validatedData = $request->validated(); // if input doesn't meet the set rules a error message will be thrown, otherwise it will continue
        $userService->store($validatedData);
        return Response(["message" => "user created successfully"], 201);
    }

}
