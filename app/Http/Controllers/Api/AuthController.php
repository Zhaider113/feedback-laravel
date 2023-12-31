<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function update_fcm_token(Request $request)
    {
        try{
            // dd($request->all());
            // $validator = Validator::make($request->all(), [
            //     'user_id' => 'required|string',
            //     'token' => 'required|string',
            //     'device_id' => 'required|string',
            //     'device_type' => 'required|string',
            // ]);
            
            $user = User::where('id', $request->user_id)->first();           
                
            $user->device_type = $request->device_type;
            $user->device_id = $request->device_id;
            $user->token = $request->token;
            $user->save();
                                     
            return response()->json([
                'status' => true,
                'message' => 'Token Updated Successfully',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ]);
        }
    }
    
    public function verify_account($email)
    {
        try{
            $user = User::where('email', $email)->first();
            if(empty($user))
            {
                return redirect()->route('login')->with('error', 'This email is not associated to any account');
            }
            
            if($user->email_verified_at != null || !empty($user->email_verified_at))
            {
                return redirect()->route('login')->with('message', 'Account has already been verified');
            }
    
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->route('login')->with('message', 'Account has been Verified');
        }catch(\Exception $e)
        {
            return redirect()->route('login')->with('error', 'There is some trouble to proceed your action');
        }
    } 

    public function validatePasswordRequest(Request $request)
    {
        // dd($request->all());
        //You can add validation login here
        $user = \DB::table('users')->where('email', '=', $request->email)->first();
        
        //Check if the user exists
        if (empty($user)) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(64),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = \DB::table('password_resets')->where('email', $request->email)->first();
        // return $tokenData;
        // return $this->sendResetEmail($request->email, $tokenData->token);
        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = \DB::table('users')->where('email', $email)->select('first_name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/').'/'. 'password/reset/' . $token . '?email=' . urlencode($user->email);

        try {
            //Here send the link with CURL with an external email API 
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://zehave.com/email_sender/public/api/send_email',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('email' => $email,'code' => $link,'pr' => 'MakeUArt'),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetPassword(Request $request)
    {
        //Validate input
        // dd("Ok");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required' 
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;
        // Validate the token
        $tokenData =\DB::table('password_resets')->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        \Auth::login($user);

        //Delete the token
        \DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect()->route('home')->with('message', 'Password has been Updated');
        //Send Email Reset Success Email
        // if ($this->sendSuccessEmail($tokenData->email)) {
        //     return view('auth.');
        // } else {
        //     return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        // }
    }
}
