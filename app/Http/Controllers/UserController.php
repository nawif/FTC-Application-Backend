<?php

namespace App\Http\Controllers;

use App\Service\UserService\UserServiceContract;
use App\Http\Requests\StoreUser;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function store(StoreUser $request, UserServiceContract $userService ) {
        $validatedData = $request->validated(); // if input doesn't meet the set rules a error message will be thrown, otherwise it will continue
        $userService->store($validatedData);
        return Response(["message" => "user created successfully"], 201);
    }

    public function getUsers()
    {
        $users = User::where('is_admin', 0)->where('id', '<>', Auth::user()->id)->get(); //every user accept the requested user and the admins
        return Response(UserResource::collection($users), 200);
    }

    public function patch(Request $request, UserServiceContract $userService)
    {
        $userService->patch($request);
    }

    public function changeProfileImage(Request $request, UserServiceContract $userService) {
        $this->validate($request, [
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $userService->addUnapprovedImage($request['img']);

        return Response(["message" => "image uploaded successfully"], 201);

    }

}
