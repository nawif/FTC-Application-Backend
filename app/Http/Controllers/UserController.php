<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\StoreUser;
use Illuminate\Auth\Access\Response;
use App\TotalPoints;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function store(StoreUser $request) {
        $validatedData = $request->validated(); // if input doesn't meet the set rules a error message will be thrown, otherwise it will continue

        $newUser = new User($validatedData);
        $newUser->password = Hash::make($validatedData['password']);
        $newUser->profilephoto = $newUser->getDefaultPhoto();

        $newUser->save();

        $newUserPoints = new TotalPoints(); //creating a record in the TotalPoints table and attaching it to the user.
        $newUserPoints->user_id=$newUser->id;

        $newUserPoints->save();

        return Response(["message" => "user created successfully"], 201);
    }



}
