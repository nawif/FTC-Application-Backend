<?php
namespace App\Service\UserService;

use App\Service\UserService\UserServiceContract;
use App\TotalPoints;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\SocialmediaAccount;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\UnapprovedImage;

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

    public function patch($user_data){
        $user = Auth::user();

        if($user_data['socialmedia'])
            $this->updateUserSocialMediaAccounts($user_data['socialmedia'], $user);

        if($user_data['password']){
            $user->password = Hash::make($user_data['password']);
            $user->save();
        }
    }

    public function addUnapprovedImage($image){
        // ini_set('memory_limit', '-1');

        $user = Auth::user();
        $extension = $image->getClientOriginalExtension();
        $filePath = 'public/users_images/pending/'.$user->id.'.'.$extension;
        $compressedImage = $this->compressUserImage($image, 'profile image');
        Storage::put($filePath, $compressedImage ->stream($extension));
        UnapprovedImage::where([['user_id',$user->id], ['status', 'PENDING']])->delete();
        UnapprovedImage::create(['user_id' => $user->id, 'extension' => $extension]);
    }

    public function approveImage($is_approved, $user_id)
    {
        $user = User::find($user_id);
        $pendingImage = UnapprovedImage::where([['user_id',$user_id], ['status', 'PENDING']])->first();
        if(!$pendingImage)
        return ['code' => 400, 'message' => 'user doesn\'t have pending image!'];
        if($is_approved){
            $user->profilephoto = $this->generateBase64UserIcons(Storage::get($pendingImage->getPath()));
            $user->save();
            $pendingImage->status = "APPROVED";
            $pendingImage->moveToApproved();
            $pendingImage->save();

            return ['code' => 200, 'message' => 'image approved and updated!'];
        }else{
            $pendingImage->status = "DENIED";
            $pendingImage->deleteFile();
            $pendingImage->save();
            return ['code' => 200, 'message' => 'image denied and delete!'];
        }
    }

    /*
    @params: $newAccounts : array of objects, each element contains platform and username
    @params$ $user : an instance of user

    @return: void, but it will update the database with the new username if exist or inter a new one
    */
    private function updateUserSocialMediaAccounts($newAccounts, $user){

        foreach ($newAccounts as $newAccount) {
            $oldAccount = SocialmediaAccount::where([
                ['user_id', $user->id],
                ['platform', $newAccount['platform']]
            ])->first();
            if($oldAccount){
                $oldAccount->update(['username' => $newAccount['username']]);
            }else{
                $newAccount['user_id'] = $user->id;
                SocialmediaAccount::create($newAccount);
            }
        }

    }

    /*
        @params: $image : Source to create an image from. can be almost anything that resemble an image, for more info look at http://image.intervention.io/api/make
        @params: $type : either "icon" or "profile image"
        @return: Instance of Intervention\Image\Image which has been compressed to an acceptable level of the image type
    */
    private function compressUserImage($image, $type){ // ratio should be 200 if you want b64 icon and 4000 if you want profile image
        if($type == 'icon')
            $ratio = 100;
        else
            $ratio = 2000;
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

        $base64String ='data:image/' . $icon->mime() . ';base64,' . base64_encode($icon->stream($icon->mime()));
        return $base64String;
    }

}
