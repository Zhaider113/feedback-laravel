<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ifExists($model, $id)
    {
        $data = $model::where('id', $id)->first();
        if($data){            
            return $data;
        }else{
            $modelNameString = explode("\\", $model);
            throw new \ErrorException($modelNameString[2].' does not Exists');
        }
    }

    public function ifEmailExists($email)
    {
        $data = User::where('email', $email)->first();
        
        if($data){           
            throw new \ErrorException('Email has already been Taken');
        }
    }

    public function success($data)
    {
        if(sizeof($data) > 1){
            return response()->json(['status' => true, 'message' => $data[0], 'data' => $data[1]], 200);
        }else{
            return response()->json(['status' => true, 'message' => $data[0]], 200);
        }     
    }

    public function error($message)
    {
        return response()->json(['status' => false, 'message' => $message], 200);           
    }

    //Delete profile image
    public function deleteExistingImage($user_id)
    {
        try{          
            $user = User::where('id', $user_id)->first(['id', 'profile_image']);

            if($user->profile_image != "" && $user->profile_image != "profile_images/default.png"){
                if(realpath($user->profile_image)){
                    unlink(realpath($user->profile_image));
                }                        
            }
        }catch(\Exception $e)
        {
            throw new \ErrorException($e->getMessage());
        }
    }

    //Phone OTP
    public function phone_otp($message, $phone)
    {
        try{
            $from = '15139604811';
            $auth_SID = 'AC484ebece8bcd4947599cc950448df185';
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twilio.com/2010-04-01/Accounts/'.$auth_SID.'/Messages.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'Body='.$message.'&From=%2B'.$from.'&To=%2B'.$phone,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic QUM0ODRlYmVjZThiY2Q0OTQ3NTk5Y2M5NTA0NDhkZjE4NTphNTAxZjZkZDNkMmU3ZDRiNGY1ZmM5NmU4YWQ2MWM5Zg==',
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }catch(\Exception $e)
        {
            throw new \ErrorException($e->getMessage());
        }
    }

    //Android Notification
    public function android_notification($token, $data)
    {
        $json_data = array('priority'=>'HIGH','to'=>$token,'data'=>$data);
                                    
        $data = json_encode($json_data);
        // return $data;
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = '';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        //End FCM Android Code
    }
    
    //iOS Notification
    public function ios_notification($token, $body, $data)
    {
        //Start FCM iOS Code 
       
        // return $token;
        $json_data = array('to'=> $token, 'mutable_content' => true, 'content_available' => true, 'notification'=>array("title"=>'EAZYLIFE', "body" => $body, "sound" => "default", "priority" => "high", "badge" => 1), 'data'=> $data);
        
        $data = json_encode($json_data);
        // return $data;                
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = '';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        
        //End FCM iOS Code
    }
    
    public function web_notification($token, $data)
    {
        // return $data['message'];
        return "Okaa";
        $SERVER_API_KEY = 'AAAAgXUczKA:APA91bGJgwkkAqlSl4qmyjRKuzIyTI-iC9JK6LDHNraBJLhHEOgBm_6QOxmFXa6MY0nh9Oe9E8WXZaTKdErW9_KLKJOQQihU2PoeMN5HIXqJa9R03XCOs_YJSyAlAfqsAX8wTOujz3zK';
        $headers = ['Authorization: key=' . $SERVER_API_KEY, 'Content-Type: application/json'];   
        
        $redirect_url = url("/");
        $msg = [
            'title' => $data['title'],
            'body' => $data['message'],
            'icon' => url('/').'/app_logo.jpg',
            'click_action' => $redirect_url,
        ];

        $payload = ['registration_ids' => [$token], 'data' => $msg];
        // return $payload;
        $ch = curl_init();
        $datastring = json_encode($payload);
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);

        $response = curl_exec($ch);
        return $response;
    }
}
