<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\VerifyEmail;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'username' => ['required','min:6','unique:users'],
            'user_type' => ['required'],
            'term_condition' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_image' => 'profile_images/default.png',
            'username' => $data['username'],
            'user_type' => $data['user_type'],
            'accept_term_and_condition' => $data['term_condition'],
        ]);

        //Here send the link with CURL with an external email API 
        $link = url('/').'/'."verify-account/".$data['email'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zehave.com/email_sender/public/api/account_verification_email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $data['email'],'code' => $link,'pr' => 'Makeuart'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        
        // $user = new User;
        // $user->first_name = $data['first_name'];
        // $user->last_name = $data['last_name'];
        // $user->email = $data['email'];
        // $user->email_verified_at = '2023-09-07 16:22:12';
        // $user->password = Hash::make($data['password']);
        // $user->profile_image = 'profile_images/default.png';
        // $user->username = $data['username'];
        // $user->user_type = $data['user_type'];
        // $user->accept_term_and_condition = $data['term_condition'];
        // $user->save();
        
        // $url = url('/').'/'."verify-account/".$data['email'];

        // $mailData = [
        //     'title' => 'Verify your email by clicking on given link',
        //     'body' => 'You can verify your email account by clicking on '.$url
        // ];
        // // Auth::logout();
        // Mail::to($data['email'])->send(new VerifyEmail($mailData));
        
        return $user;
    }
}
