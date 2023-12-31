<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\GetMessanger;
use App\Events\NotificationCounter;
use App\Events\GetMessages;
use App\Events\ChatNotificationEvent;
use App\Events\AssignTask;
use App\Events\MessageCounter;
use App\Models\UserToken;
use App\Models\Booking;
use Carbon\Carbon;
use Validator;

class ChatController extends Controller
{
    public $user_avatar = "https://cdn-icons-png.flaticon.com/128/3177/3177440.png";
    //Android Notification
    ///////////////////////////////
    public function android_notification($token, $data)
    {
        $json_data = array('priority'=>'HIGH','to'=>$token,'data'=>$data);
                                    
        $data = json_encode($json_data);
        // return $data;
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAADQ3msYg:APA91bEf68CnRSmi8fRceaxbJJe2Bsycn46isuA-6v0GXHSDuC47xvbIdF0LBXx3kIejIFtue0snfsqy7OCLy28PkeOm6iPIx_rHk9Mcst9uzr66hA4pz3C8b3EMFKq3tQh765a3eu4a';
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

    public function web_notification($token, $data)
    {
        // return $data['message'];
        $SERVER_API_KEY = 'AAAADQ3msYg:APA91bEf68CnRSmi8fRceaxbJJe2Bsycn46isuA-6v0GXHSDuC47xvbIdF0LBXx3kIejIFtue0snfsqy7OCLy28PkeOm6iPIx_rHk9Mcst9uzr66hA4pz3C8b3EMFKq3tQh765a3eu4a';
        $headers = ['Authorization: key=' . $SERVER_API_KEY, 'Content-Type: application/json'];

        // $msg = [
        //     'title' => 'Local Notification',
        //     'body' => 'Local Body',
        //     'icon' => 'https://valorantinfo.gg/wp-content/uploads/2021/09/valorant-sentinels-of-light-buddy.png',
        //     'image' => 'https://valorantinfo.gg/wp-content/uploads/2021/09/valorant-sentinels-of-light-buddy.png',
        //     'click_action' => 'https://joinsentinels.com/noti/public/',
        // ];       
        
        // if($data['notification_type'] == "chat")
        // {
        //     $redirect_url = url("/")."/user/get-messages/".$user_id;
        // }else{
        //     $redirect_url = url("/")."/user";
        // }
        $redirect_url = "";

        $msg = [
            'title' => $data['title'],
            'body' => $data['message'],
            'icon' => url('/').'/app_logo.jpg',
            'click_action' => $redirect_url,
        ];

        $payload = ['registration_ids' => [$token], 'data' => $msg];

        $ch = curl_init();
        $datastring = json_encode($payload);
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datastring);

        $response = curl_exec($ch);
        // return $response;
    }
    
    public function user_model($user_id)
    {
        $user = User::where('id', $user_id)->first();
        // if(!empty($user))
        // {
        //     $user->profile_image = url('/').'/'.$user->profile_image;
        // }
        
        return $user;
    }

    public function get_messanger($user_id)
    {
        try{
            $user = User::find($user_id);
            if(empty($user)){
                return response()->json([
                    'status' => false,
                    'message' => 'User does not Exists!',                    
                ], 200);
            }     
            if($message_type == "session")
            {
                $user_array = array();            
                $latest_messages = Message::orWhere('from_id', $user_id)->orWhere('to_id', $user_id)->orderBy('time', 'desc')->get();            
                if(!empty($latest_messages)){
                    foreach($latest_messages as $message){
                        if($message->from_id == $user_id){
                            array_push($user_array, $message->to_id);                        
                        }else if($message->to_id == $user_id){                        
                            array_push($user_array, $message->from_id);
                        }
                    }
                }            
                $arr = array_unique($user_array);
                $arr1 = array();
                
                if(!empty($arr)){
                    foreach($arr as $ar){
                        array_push($arr1, $ar);
                    }
                }            
                // return $arr1; // messanger array;
                $messanger_array = array();            
                if(sizeof($arr1) > 0){
                    foreach($arr1 as $ar1){                    
                        $message1 = Message::where('from_id', $ar1)->where('to_id', $user_id)->where('message_type', 'session')->orderBy('time', 'desc')->first();
                        $message2 = Message::where('from_id', $user_id)->where('to_id', $ar1)->where('message_type', 'session')->orderBy('time', 'desc')->first();
                        if(!empty($message1) && !empty($message2)){
                            if($message1->id > $message2->id){
                                array_push($messanger_array, $message1);
                            }else{
                                array_push($messanger_array, $message2);
                            }
                        }else if(empty($message1) && !empty($message2)){
                            array_push($messanger_array, $message2);
                        }else if(empty($message2) && !empty($message1)){
                            array_push($messanger_array, $message1);
                        }
                    }
                }
                // return $messanger_array;
                $inbox = array();            
                if(sizeof($messanger_array) > 0){
                    foreach($messanger_array as $messanger){
                        if($messanger->to_id == $user_id){
                            $to1 = Message::where('to_id', $user_id)->where('from_id', $messanger->from_id)->where('message_type', 'session')->where('seen', 'false')->count();
                            
                            $user_details = User::where('id', $messanger->from_id)->first();
                            $messanger->other_user_id = $user_details->id;
                            $messanger->time = json_decode($messanger->time);
                            $messanger->message_time = Carbon::parse($messanger->created_at)->diffForHumans();
                            $messanger->other_user_name = $user_details->username;
                            $messanger->other_user_avatar = IMAGE_URL.$user_details->profile_image;
                            $messanger->other_user_type = $user_details->type;
                            $messanger->unread_messages = $to1;                        
                            array_push($inbox, $messanger);
                        }else if($messanger->from_id == $user_id)
                        {
                            $user_details = User::where('id', $messanger->to_id)->first();                        
                            $messanger->other_user_id = $user_details->id;                        
                            $messanger->time = json_decode($messanger->time);
                            $messanger->message_time = Carbon::parse($messanger->created_at)->diffForHumans();
                            $messanger->other_user_name = $user_details->username;
                            $messanger->other_user_avatar = IMAGE_URL.$user_details->profile_image;
                            $messanger->other_user_type = $user_details->type;
                            $messanger->unread_messages = 0;
                            array_push($inbox, $messanger);
                        }
                    }
                }
                
                // return $inbox;
                
                return response()->json([
                    'status' => sizeof($inbox) > 0 ? true : true,
                    'message' => sizeof($inbox) > 0 ? 'Messanger Found' : 'No Messanger Found',
                    'data' => sizeof($inbox) > 0 ? $inbox : [],
                ], 200);
            }elseif($message_type == "text"){
                //group message
                $inbox = array();
                $groups = SecurityRequestChatGroupMember::where('member_id', $user_id)->pluck('group_id');
                $security_requests = SecurityRequestChatGroup::whereIn('id', $groups)->pluck('security_request_id');    
                $inbox1 = Message::whereIn('security_request_id', $security_requests)->latest()->get()->unique('security_request_id');
                if(sizeof($inbox1) > 0){
                    foreach($inbox1 as $messanger){
                        if($messanger->conversation_type == "group" && empty($messanger->to_id))
                        {
                            $user_details = User::where('id', $messanger->from_id)->first();                        
                            $messanger->other_user_id = $user_details->id;                        
                            $messanger->time = json_decode($messanger->time);
                            $messanger->message_time = Carbon::parse($messanger->created_at)->diffForHumans();
                            $messanger->other_user_name = $user_details->username;
                            $messanger->other_user_avatar = IMAGE_URL.$user_details->profile_image;
                            $messanger->other_user_type = $user_details->type;
                            $messanger->unread_messages = 0;
                            array_push($inbox, $messanger);
                        }
                    }
                }
                return response()->json([
                    'status' => sizeof($inbox) > 0 ? true : true,
                    'message' => sizeof($inbox) > 0 ? 'Messanger Found' : 'No Messanger Found',
                    'data' => sizeof($inbox) > 0 ? $inbox : [],
                ], 200);
            }else{
                //invalid message type
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Message Type',                
                ], 200);
            }           
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action!',                
            ], 200);
        }
    }

    public function get_messages($self_id, $user_id, $message_type)
    {
        try{
            $self = User::find($self_id);
            if(empty($self)){
                return response()->json([
                    'status' => false,
                    'message' => 'Self User does not Exists!',                    
                ], 200);
            }
            if($message_type == "session")
            {
                $user = User::find($user_id);            
                if(empty($user)){
                    return response()->json([
                        'status' => false,
                        'message' => 'User does not Exists!',                   
                    ], 200);
                }           
                
                $messages1 = Message::where('from_id', $user_id)->where('to_id', $self_id)->where('message_type', $message_type)->orderBy('time', 'desc')->get();
                if(!empty($messages1)){
                    foreach($messages1 as $message1){                     
                        $message1->time = json_decode($message1->time);
                        $message1->seen = json_decode($message1->seen);
                        if($message1->media != ""){ $message1->media = url('/').'/'.$message1->media; }                   
                        if($message1->from_id != $self_id){
                            $message1->other_user = $this->user_model($message1->from_id);
                        }else{
                            $message1->other_user = $this->user_model($message1->to_id); 
                        }
                    }
                }            
                // return $messages1;            
                $messages2 = Message::where('from_id', $self_id)->where('to_id', $user_id)->where('message_type', $message_type)->orderBy('time', 'desc')->get();
                
                if(!empty($messages2)){
                    foreach($messages2 as $message2){
                        $message2->time = json_decode($message2->time);
                        $message2->seen = json_decode($message2->seen);
                        if($message2->media != ""){ $message2->media = url('/').'/'.$message2->media; }                    
                        
                        if($message2->from_id != $self_id){
                            $message2->other_user = $this->user_model($message2->from_id);
                        }else{
                            $message2->other_user = $this->user_model($message2->to_id); 
                        }                    
                    }
                }
                
                $merged = $messages1->merge($messages2);           
                $sorted = $merged->sortBy('id');            
                $all_messages = $sorted->values()->all();
                // return $all_messages;
                return response()->json([
                    'status' => sizeof($all_messages) > 0 ? true : true,
                    'message' => sizeof($all_messages) > 0 ? 'Messages Found' : 'No Messages Found',
                    'admin_status' => 0,
                    'data' => sizeof($all_messages) > 0 ? $all_messages : [],
                ], 200);
            }elseif($message_type == "text")
            {
                //if message_type param is text, then receive security_request_id from mobile app
                //i'm take security_request_id in param of user_id in case of text chat
                // $security_request = SecurityRequest::
                $security_request_id = $user_id; //receiving security request id in param of user_id
                $all_messages = Message::where('security_request_id', $security_request_id)        
                ->orderBy('id', 'asc')
                ->get();

                if(!empty($all_messages))
                {
                    foreach($all_messages as $message)
                    {                     
                        $message->time = json_decode($message->time);
                        $message->seen = json_decode($message->seen);

                        if($message->media != "")
                        {
                            $message->media = url('/').'/'.$message->media;
                        }                    

                        $message->other_user = $this->user_model($message->from_id);                
                    }
                } 
                $group = SecurityRequestChatGroup::where('security_request_id', $security_request_id)->first();
                if(!empty($group))
                {
                    $member = SecurityRequestChatGroupMember::where('group_id', $group->id)->where('member_type', 'admin')->first();
                    $is_active = $member->is_active;
                }else{
                    $is_active = 0;
                }              
                
                return response()->json([
                    'status' => true,
                    'message' => $all_messages->count() > 0 ? 'Messages Found' : 'No Message Found',
                    'admin_status' => $is_active,
                    'data' => $all_messages,
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Message Type',                    
                ], 200);
            }           
            
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action!',             
            ], 200);
        }
    }

    public function send_message(Request $request)
    {
        // try{
            $validator = Validator::make($request->all(),[
                'from_id' => 'required|exists:users,id',
                'to_id' => 'required',
                'text' => 'sometimes|nullable',
                'media_type' => 'sometimes|nullable',
                'media' => 'sometimes|nullable',
                'message_type' => 'required|string|in:text,media',
            ]);
            $todayDate = Carbon::now()->format('d F Y');

            if($validator->fails()){ return $this->error($validator->errors()->first()); }
            // checking user booking 
            $senderBooking = Booking::where('booking_date', '>=',$todayDate)->orWhere('booking_user_id', $request->from_id)->orWhere('booking_against_user_id', $request->to_id)->where('status', 'completed')->first();
            if(!empty($senderBooking)){
                return $this->error("Message can't be send Order already Completed...!");
            }
            // checking sender booking
            $senderBooking = Booking::where('booking_date', '>=',$todayDate)->orWhere('booking_user_id', $request->to_id)->orWhere('booking_against_user_id', $request->from_id)->where('status', 'completed')->first();
            if(!empty($senderBooking)){
                return $this->error("Message can't be send Order already Completed...!");
            }

            $from = User::where('id', $request->from_id)->first();
            $to = User::where('id', $request->to_id)->first(); 
          
            $messages1 = Message::where('from_id', $request->from_id)
            ->where('to_id', $request->to_id)
            ->orderBy('time', 'desc')
            ->first();
            // return $messages1;
            
            $messages2 = Message::where('from_id', $request->to_id)
            ->where('to_id', $request->from_id)
            ->orderBy('time', 'desc')
            ->first();
            
            if(empty($messages1) && empty($messages2))
            {
                $msg = new Message;
                $msg->from_id = $request->from_id;
                $msg->to_id = $request->to_id;
                $msg->message_type = "text";
                $msg->text = 'Started at Today';
                $msg->save();
            }  

            $message = new Message;
            $message->from_id = $request->from_id;            
            if($request->has('text') && $request->text != ""){ $message->text = $request->text; }
            if($request->has('message_type') && $request->message_type != ""){
                $message->message_type = $request->message_type;               
            }
            // if($request->has('media_type') && $request->media_type != ""){
            //     if($request->has('media') && $request->media != ""){                    
            //         $newfilename = md5(mt_rand()) .'.'. $request->media->getClientOriginalExtension();
            //         $request->file('media')->move(public_path("/chat_media"), $newfilename);
            //         $new_path1 = 'chat_media/'.$newfilename;
            //         $message->media = $new_path1;
            //         $message->media_type = $request->media_type;                                          
            //     }
            // }
            
            $message->to_id = $request->to_id;            
            $message->time = time();            
            $message->save();
            //send push notification
            $inbox = []; 
            $latest_message = Message::where('from_id', $request->from_id)->latest()->first();                               
            $from_user = $latest_message;
            $from_user->other_user = $this->user_model($latest_message->to_id);
            
            $to_user = $latest_message;
            $to_user->other_user = $this->user_model($latest_message->from_id);
            if($from_user->media != ""){ $from_user->media = url('/').'/'.$from_user->media; }  
            $to_us = User::where('id', $request->to_id)->first();
            // return $to_us->first_name;
            //send push notification to subaccount because chat is among parent and subaccount
            // $this->create_notification(2, 3, "MAKEUART", "New Message from Kamran", 0, 'chat');
            $this->create_notification($request->from_id, $request->to_id, "MAKEUART", "Message from ".$from->first_name, null,'chat');
            event(new GetMessanger(User::find($request->to_id), $inbox));                     
            // event(new GetMessages(User::find($request->from_id), json_decode(json_encode($from_user))));
            // event(new GetMessages(User::find($request->to_id), json_decode(json_encode($to_user))));
                      
            return $this->success(['Message Sent']); 
        // }catch(\Exception $e){
        //     return $this->error($e->getMessage());
        // }
    }

    public function delete_message($message_id)
    {
        try{    
            $message = Message::find($message_id);

            if(empty($message))
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Message does not Exists',                    
                ], 200);
            }

            $message->delete();

            return response()->json([
                'status' => false,
                'message' => 'Message Deleted!',                
            ], 200);

        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action!',               
            ], 200);
        }        
    }    

    public function edit_message(Request $request)
    {
        try{    
            $message = Message::find($request->message_id);

            if(empty($message))
            {
                return response()->json([
                    'status' => 400,
                    'message' => 'Message does not Exists',
                    'data' => null,
                ], 200);
            }

            if($request->has('text'))
            {
                $message->text = $request->text;
                $message->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Message Updated!',
                'data' => null,
            ], 200);
            
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => 400,
                'message' => 'There is some trouble to proceed your action!',
                'data' => null,
            ], 200);
        }        
    } 
    
    public function delete_messenger($self_id, $user_id)
    {
        try{
            $self = User::where('id', $self_id)->first('id');
            
            if(empty($self))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Self does not Exists!',                   
                ], 200);
            }
            
            $user = User::where('id', $user_id)->first('id');
            
            if(empty($user))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not Exists!',                  
                ], 200);
            }
            
            $from = Message::where('from_id', $self_id)
            ->where('to_id', $user_id)
            ->delete();
            
            $to = Message::where('to_id', $self_id)
            ->where('from_id', $user_id)
            ->delete();
            
            return response()->json([
                'status' => true,
                'message' => 'Chat Deleted',                
            ], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action!',              
            ], 200);
        }
    }
    
    public function read_messages($self_id, $user_id)
    {
        try{
            $self = User::where('id', $self_id)->first('id');
            
            if(empty($self))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Self User does not Exists',                    
                ], 200);
            }
            
            $user = User::where('id', $user_id)->first('id');
            
            if(empty($user))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not Exists',                    
                ], 200);
            }
            
            $to = Message::where('to_id', $self_id)
            ->where('from_id', $user_id)
            ->where('seen', 'false')
            ->get();
            
            if(!empty($to))
            {
                foreach($to as $t)
                {
                    $t->seen = 1;
                    $t->save();
                }
            }
            
            $from = Message::where('from_id', $self_id)
            ->where('to_id', $user_id)
            ->where('seen', 'false')
            ->get();
            
            if(!empty($from))
            {
                foreach($from as $f)
                {
                    $f->seen = 1;
                    $f->save();
                }
            }
            
            return response()->json([
                'status' => true,
                'message' => 'Messages Seen',               
            ], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',                
            ], 200);
        }
    }
    
    public function check_message(Request $request)
    {        
        if($request->last_message_id > 0)
        {
            $message = Message::where('to_id', $request->self_id)->orderBy('id', 'desc')->first();
            if(!empty($message))
            {
                if($message->id > $request->last_message_id)
                {
                    $message->other_user = $this->user_model($message->from_id);  
                    // $message->other_user = $message->other_user->profile_image;
                    return response()->json($message); 
                }else{
                    return response()->json("None"); 
                }                    
            }else{
                return response()->json("None"); 
            }
        }else{
            return response()->json("None"); 
        }              
    }
    
    public function check_message_messanger(Request $request)
    {        
        $message = Message::where('to_id', $request->self_id)->orderBy('id', 'desc')->first();
        if(!empty($message))
        {
            $message->other_user = $this->user_model($message->from_id);  
            $message->other_user->profile_image = $this->user_avatar;
            return response()->json($message); 
        }else{
            return response()->json("None"); 
        }
    }

    public function check_status($security_request_id)
    {
        $group = SecurityRequestChatGroup::where('security_request_id', $security_request_id)->first();
        $member = SecurityRequestChatGroupMember::where('member_type', 'admin')->where('group_id', $group->id)->first();

        return json_encode($member->is_active);
    }

    public function test_notification()
    {
        // return $data['message'];
        $SERVER_API_KEY = 'AAAAgXUczKA:APA91bGJgwkkAqlSl4qmyjRKuzIyTI-iC9JK6LDHNraBJLhHEOgBm_6QOxmFXa6MY0nh9Oe9E8WXZaTKdErW9_KLKJOQQihU2PoeMN5HIXqJa9R03XCOs_YJSyAlAfqsAX8wTOujz3zK';
        $headers = ['Authorization: key=' . $SERVER_API_KEY, 'Content-Type: application/json'];    
        
        $redirect_url = "";
        $msg = [
            'title' => "Title",
            'body' => "This is Message",
            'icon' => "https://static-00.iconduck.com/assets.00/brand-html5-icon-256x256-ayjqvc9x.png",
            'click_action' => $redirect_url,
        ];
        $token = "d4FuFRcTtkb9HASckBDNKd:APA91bHenTzoTUlp952GeSuxYYEPDSjstHYMfPYB2YHBadT9zSpJ0y43QVmdl5YeImiTQ7BZvv_hzmCRB4jUHpRMTJkr8AKuKPvXg0BRGMV2w6N3r1G-aoua4xon4VqnuoGfOEuWXXq8";
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
