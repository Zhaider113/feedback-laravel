<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class SettingController extends Controller
{
   public function view_setting(){
        return view('users.settings.index');
   }

   public function update_information(Request $request){
    // dd($request->all());
        $user = User::where('id',Auth::id())->first();
        if($request->has('first_name') && $request->first_name !="" || $request->first_name !=null){
            $user->first_name = $request->first_name;
        }
        if($request->has('last_name') && $request->last_name !="" || $request->last_name !=null){
            $user->last_name = $request->last_name;
        }
        if($request->has('username') && $request->username !="" || $request->username !=null){
            $user->username = $request->username;
        }
        if($request->has('email') && $request->email !="" || $request->email !=null){
            $user->email = $request->email;
        }
        if($request->has('phone') && $request->phone !="" || $request->phone !=null){
            $user->phone = $request->phone;
        }
        
        if($request->has('old_password') && $request->old_password !="" || $request->old_password !=null){
            if (Hash::check($request->old_password,$user->password)){
                if($request->has('new_password') && $request->new_password !="" || $request->new_password !=null){
                    $user->password = bcrypt($request->new_password);
                }
            }
            else{
                return back()->with('error','First Correct Your Old Password !');
            }
        }
        if($request->has('profile_image') && $request->profile_image != ""){
            if($request->profile_image->getClientOriginalExtension() == 'png'||$request->profile_image->getClientOriginalExtension() == 'PNG'|| $request->profile_image->getClientOriginalExtension() == 'jpg'|| $request->profile_image->getClientOriginalExtension() == 'JPG'|| $request->profile_image->getClientOriginalExtension() == 'jpeg'|| $request->profile_image->getClientOriginalExtension() == 'JPEG')
            {
                $newfilename = md5(mt_rand()) .'.'. $request->profile_image->getClientOriginalExtension();
                $request->file('profile_image')->move(public_path("/profile_images"), $newfilename);
                $new_path1 = 'profile_images/'.$newfilename;
                $user->profile_image = $new_path1;
            }
            else{
                return back()->with('error','Choose a Valid Image !');
            }                       
        }    
        $user->save();
        if($user){
            return back()->with('success','Your Information Updated Successfully!');
        }   
        else{
            return back()->with('error','Sorry There is a Problem in Process!');
        }
    }

    public function delete_auth_account(){
        $user = User::where('id',Auth::id())->first();
        if(!empty($user)){
            $user->delete();
            return redirect()->to('/');
        }
        else{
            return back()->with('error','There is a problem!');
        }
    }
}
