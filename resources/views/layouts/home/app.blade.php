<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('theme/home/style/style.css')}}">
    <link rel="stylesheet" href="{{asset('theme/home/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="shortcut icon" href="{{ asset('favicon.png')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    
    <title>Feedback System</title>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>-->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    
    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyCdSzlzTyuw1sbG9YrWEJ9nX15JvtROwN4",
            authDomain: "makeuart-29386.firebaseapp.com",
            projectId: "makeuart-29386",
            storageBucket: "makeuart-29386.appspot.com",
            messagingSenderId: "556015602848",
            appId: "1:556015602848:web:91851e2dedcb311fa94dc5",
            measurementId: "G-1EFWRBCYE3"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                // alert("Ok");
                return messaging.getToken()
            }).then(function(token) {
                // console.log(token)
                // alert(token)
                // $.ajax({
                //     url: "{{ url('/').'/api/update-fcm-token' }}",
                //     type:'POST',
                //     data: {         
                //         "user_id": "", 
                //         "token": token, 
                //         "device_type": "desktop",
                //         "device_id": navigator.userAgent,                  
                //     },
                //     success:function(data, status){
                //         // console.log(data)   
                //         // alert(data.message);   
                //     },
                // });

            }).catch(function (err) {
                console.log(err);
            });
        }

        initFirebaseMessagingRegistration();

        if (!("Notification" in window)) {
            // Check if the browser supports notifications
            // alert("This browser does not support desktop notification");
        } else if (Notification.permission === "granted") {
            // Check whether notification permissions have already been granted;
            // if so, create a notification
            // const notification = new Notification("Hi there!");
            // …
        } else if (Notification.permission !== "denied") {
            // We need to ask the user for permission
            Notification.requestPermission().then((permission) => {
                // If the user accepts, let's create a notification
                if (permission === "granted") {
                    // const notification = new Notification("Hi there!");
                    // messaging.onMessage(function({data:{body,title}}){
                    //     new Notification(title, {body});
                    // });
                }
            });
        }else if (Notification.permission === "denied") {
            // alert("You need to give notifications permission for this browser");
        }

        messaging.onMessage(function({data:{body,title}}){
            new Notification(title, {body});
        });

        messaging.onMessage(function(payload) {
            // console.log(payload);
            var title = payload.data.title;
            // var options = {
            //     body: payload.data.body,
            //     icon: payload.data.icon,
            //     image: payload.data.image,
            //     data: {
            //         time: new Date(Date.now()).toString(),
            //         click_action: payload.data.click_action
            //     }
            // };
            var options = {
                body: payload.data.body,
                icon: payload.data.icon,
                data: {
                    time: new Date(Date.now()).toString(),
                    click_action: payload.data.click_action
                }
            };
            var myNotification = new Notification(title, options);
            
            // myNotification.addEventListener("click", function(){
            //     console.log("clicked");
            //     console.log(event);
            //     var action_click = event.srcElement.data.click_action;
            //     console.log(action_click);
            //     //   event.notification.close();
                
            //     //   event.waitUntil(
            //     //     clients.openWindow(action_click)
            //     //   );
            //     window.open(action_click);
            // });
        });

</script>

</head>
<body>
<div  class="col-md-11 text-center" style="position: absolute;top: 60px; right: 26px;z-index: 3; width: fit-content;">
        @if(session()->has('success'))
            <div class="alert alert-success text-center" id="success">
            <!--<button type="button" class="close" data-dismiss="alert" style="margin-left: 20px;margin-top: -4px;">x</button>-->
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-warning text-center" id="error">
            <!--<button type="button" class="close" data-dismiss="alert" style="margin-left: 20px;margin-top: -4px;">x</button>-->
                {{ session()->get('error') }}
            </div>
        @endif
    </div> 
@include('layouts.home.header')

@yield('content')


<script src="{{asset('theme/home/JavaScript/main.js')}}"></script>
<script src="{{asset('theme/home/bootstrap/js/bootstrap.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">
    $("document").ready(function()
    {
        setTimeout(function()
        {
            $("#success").remove();
        },3000);
    });
</script>
<script type="text/javascript">
    $("document").ready(function()
    {
        setTimeout(function()
        {
            $("#error").remove();
        },3000);
    });
</script>



</body>
</html>