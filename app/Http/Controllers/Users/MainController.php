<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\ContactUs;
use App\Models\Categories;
use App\Models\JobsMedia;
use App\Models\SliderDetails;
use App\Models\Booking;
use App\Models\User;
use App\Models\Job;
use Auth;

class MainController extends Controller
{
    public function dashboard(){
        $notification_count = Notification::where('notification_to', \Auth::user()->id)->count();
        $notifications = Notification::where('notification_to', \Auth::user()->id)->orderBy('id', 'desc')->limit(3)->get();
        if(!empty($notifications))
        {
            foreach($notifications as $notification)
            {
                $user = User::where('id',$notification->notification_from)->first();
                if(!empty($user)){
                    $first_name = $user->first_name;
                    $last_name = $user->last_name;
                    $full_name = $first_name.' '.$last_name;
                    $notification ->fullname = $full_name;
                }
            }
        }

        return view('users.dashboard',compact(['notification_count','notifications']));
    }

    public function contact_us_message(Request $req){
        $contact = new ContactUs();
        $req->name = Auth::user()->id;
        $user_id = $req->name;
        $contact->user_id = $user_id;
        $contact->message = $req->message;
        $contact->save();
        if($contact){
            return back()->with('success','Message Submited Successfully !');
        }
        else{
            return back()->with('error','Message Not Submited , There is Some Issue !');
        }       
    }
    
    public function contact_message(Request $request){
        $contact = new ContactUs();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
        if($contact){
            return back()->with('success','Thank You for Contact Us!');
        }
        else{
            return back()->with('error','Message Not Submited , There is Some Issue !');
        }       
    }
    
    public function filters(Request $request)
    {
        try{
            // dd($request->all());
            if($request->keyword && $request->category && $request->max_price){         
                $jobs = Job::with('job_reviews')->orWhere('category_id', $request->category)->orWhere('title', 'like', '%' . $request->keyword . '%')->orWhere('description', 'like', '%' . $request->keyword . '%')->orWhere('keywords', 'like', '%' . $request->keyword . '%')->orWhere('price',  '=<', $request->max_price)->get();
            }elseif($request->keyword && $request->category){   
                $jobs = Job::with('job_reviews')->where('keywords',$request->keyword)->where('category_id',$request->category)->get();
            } elseif($request->category && $request->max_price){  
                $jobs = Job::with('job_reviews')->where('category_id',$request->category)->where('price', '<=' ,json_decode($request->max_price))->get();
            } elseif($request->keyword && $request->max_price){    
                $jobs = Job::with('job_reviews')->where('keywords',$request->keyword)->where('price', '<=' ,json_decode($request->max_price))->get();
            }elseif($request->keyword){ 
                $jobs = Job::with('job_reviews')->orWhere('title', 'like', '%' . $request->keyword . '%')->orWhere('description', 'like', '%' . $request->keyword . '%')->orWhere('keywords', 'like', '%' . $request->keyword . '%')->get();
            }elseif($request->category){
                $jobs = Job::with('job_reviews')->Where('category_id', $request->category)->get();
            }elseif($request->max_price){  
                $jobs = Job::with('job_reviews')->Where('price', '<=' ,json_decode($request->max_price))->get();
            }
            
            if(!empty($jobs))
            {
                foreach($jobs as $job)
                {
                    $sum = 0;
                    foreach($job->job_reviews as $review){
                        $sum += $review->rating;
                    }
                    if($sum > 0){
                        $rating = $sum / count($job->job_reviews);
                    }else{
                        $rating = $sum;
                    }
                    $job->total_reviews = $rating;
                    $user = User::where('id',$job->user_id)->first();
                    if(!empty($user)){
                        $job->profile_image = $user->profile_image;
                    }
                    else {
                        $job->profile_image = "";
                    }

                    $category = Categories::where('id',$job->category_id)->first();
                    if(!empty($category)) {
                        $job->category_name = $category->category_name;
                    }
                    else {
                        $job->category_name = "";
                    }

                    $job_image =  JobsMedia::where('job_id',$job->id)->first();
                    if(!empty($job_image)) {
                        $job->job_image = $job_image->media;
                    }
                    else {
                        $job->job_image = "";
                    }  
                }
            }else{
                $jobs = [];
            }
            $job_categories = Categories::orderby('created_at','desc')->get();
            $sliders = SliderDetails::orderby('created_at','asc')->get();
            if(empty($jobs))
            {
                $count = 0;
            }else{
                $count = $jobs->count();
            }
            
            return view('search_results', compact(['jobs', 'job_categories', 'sliders','count']));
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }       
    }

    public function give_rating(Request $request, $id){
        $find_booking = Booking::where('id',$id)->first();
        if(!empty($find_booking)){
            $find_job = Job::where('id',$find_booking->job_id)->first();
            if(!empty($find_job)){
                return $find_job;
            }
            else{
                return back()->with('error','This job is not found !');
            }
        }
        else{
            return back()->with('error','This booking is not found !');
        }
    }
    
    public function view_category_jobs($category_id){
        if($category_id == "1"){
            $count = Job::where('category_id',$category_id)->count();
            $jobs = Job::where('category_id',$category_id)->get();
            if(!empty($jobs)){
                foreach($jobs as $job){
                    
                    $user = User::where('id',$job->user_id)->first();
                    if(!empty($user)){
                        $job->profile_image = $user->profile_image;
                    }
                    else {
                        $job->profile_image = "";
                    }
                    
                    $job_image =  JobsMedia::where('job_id',$job->id)->first();
                    if(!empty($job_image)) {
                        $job->job_image = $job_image->media;
                    }
                    else {
                        $job->job_image = "";
                    } 
                    
                    $category = Categories::where('id',$job->category_id)->first();
                    if(!empty($category)) {
                        $job->category_name = $category->category_name;
                    }
                    else {
                        $job->category_name = "";
                    }
                    
                }
            }
            return view('category_jobs.skin_jobs',compact(['count','jobs']));
        }
        
        elseif($category_id == "2"){
            $count = Job::where('category_id',$category_id)->count();
            $jobs = Job::where('category_id',$category_id)->get();
            if(!empty($jobs)){
                foreach($jobs as $job){
                    
                    $user = User::where('id',$job->user_id)->first();
                    if(!empty($user)){
                        $job->profile_image = $user->profile_image;
                    }
                    else {
                        $job->profile_image = "";
                    }
                    
                    $job_image =  JobsMedia::where('job_id',$job->id)->first();
                    if(!empty($job_image)) {
                        $job->job_image = $job_image->media;
                    }
                    else {
                        $job->job_image = "";
                    } 
                    
                    $category = Categories::where('id',$job->category_id)->first();
                    if(!empty($category)) {
                        $job->category_name = $category->category_name;
                    }
                    else {
                        $job->category_name = "";
                    }
                    
                }
            }
            return view('category_jobs.hair_jobs',compact(['count','jobs']));
        }
        
        elseif($category_id == "3"){
            $count = Job::where('category_id',$category_id)->count();
            $jobs = Job::where('category_id',$category_id)->get();
            if(!empty($jobs)){
                foreach($jobs as $job){
                    
                    $user = User::where('id',$job->user_id)->first();
                    if(!empty($user)){
                        $job->profile_image = $user->profile_image;
                    }
                    else {
                        $job->profile_image = "";
                    }
                    
                    $job_image =  JobsMedia::where('job_id',$job->id)->first();
                    if(!empty($job_image)) {
                        $job->job_image = $job_image->media;
                    }
                    else {
                        $job->job_image = "";
                    } 
                    
                    $category = Categories::where('id',$job->category_id)->first();
                    if(!empty($category)) {
                        $job->category_name = $category->category_name;
                    }
                    else {
                        $job->category_name = "";
                    }
                    
                }
            }
            return view('category_jobs.makeup_jobs',compact(['count','jobs']));
        }
        
        elseif($category_id == "4"){
            $count = Job::where('category_id',$category_id)->count();
            $jobs = Job::where('category_id',$category_id)->get();
            if(!empty($jobs)){
                foreach($jobs as $job){
                    
                    $user = User::where('id',$job->user_id)->first();
                    if(!empty($user)){
                        $job->profile_image = $user->profile_image;
                    }
                    else {
                        $job->profile_image = "";
                    }
                    
                    $job_image =  JobsMedia::where('job_id',$job->id)->first();
                    if(!empty($job_image)) {
                        $job->job_image = $job_image->media;
                    }
                    else {
                        $job->job_image = "";
                    } 
                    
                    $category = Categories::where('id',$job->category_id)->first();
                    if(!empty($category)) {
                        $job->category_name = $category->category_name;
                    }
                    else {
                        $job->category_name = "";
                    }
                    
                }
            }
            return view('category_jobs.hair_styling_jobs',compact(['count','jobs']));
        }
    }
    
    public function get_notifications(){

        $notifications = Notification::where('notification_to', \Auth::user()->id)->orderBy('id', 'desc')->get();
        if(!empty($notifications))
        {
            foreach($notifications as $notification)
            {
                $user = User::where('id',$notification->notification_from)->first();
                if(!empty($user)){
                    $first_name = $user->first_name;
                    $last_name = $user->last_name;
                    $full_name = $first_name.' '.$last_name;
                    $notification ->fullname = $full_name;
                }
            }
        }

       return view('users.notifications.index',compact(['notifications']));
    }
    
}
