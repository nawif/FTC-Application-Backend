<?php
namespace App\Service\UserService;

use App\Service\UserService\UserServiceContract;
use App\TotalPoints;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\SocialmediaAccount;

class UserService implements UserServiceContract{

    public function store($user_data)
    {
        $newUser = new User($user_data);
        $newUser->password = Hash::make($user_data['password']);
        $newUser->profilephoto = $newUser->getDefaultPhoto();

        $newUser->save();

        $newUserPoints = new TotalPoints(); //creating a record in the TotalPoints table and attaching it to the user.
        $newUserPoints->user_id=$newUser->id;
        $newUserPoints->save();

        $defaultWhatsappNumber = new SocialmediaAccount([
            'platform'=>'whatsapp',
            'username'=>$newUser->phone,
            'user_id'=>$newUser->id,
        ]);
        $defaultWhatsappNumber->save();
    }
}
