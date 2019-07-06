<?php
namespace App\Service\UserService;

use App\Service\UserService\UserServiceContract;
use App\TotalPoints;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\SocialmediaAccount;
use Intervention\Image\ImageManagerStatic as Image;


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

    /*
        @params: $image : Source to create an image from. can be almost anything that resemble an image, for more info look at http://image.intervention.io/api/make
        @params: $type : either "icon" or "profile image"
        @return: base 64 string of the passed icon
    */
    private function compressUserImage($image, $type){ // ratio should be 200 if you want b64 icon and 4000 if you want profile image
        if($type == 'icon')
            $ratio = 200;
        else
            $ratio = 4000;
        $img=Image::make($image)->resize(null, $ratio, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img;
    }

    /*
        @params: $image : Intervention Image instance
        @return: base 64 string of the passed icon
    */
    private function generateBase64UserIcons($image){

        $icon = $this->compressUserImage($image,'icon');
        // $type = pathinfo($path, PATHINFO_EXTENSION);

        $base64String ='data:image/' . $icon->mime() . ';base64,' . base64_encode($icon);
        return $base64String;
    }

}
