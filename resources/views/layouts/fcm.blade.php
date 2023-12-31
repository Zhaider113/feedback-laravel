<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
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

    function initFirebaseMessagingRegistration(user_id) {
        messaging.requestPermission().then(function () {
            return messaging.getToken()
        }).then(function(token) {
            console.log(token)
            // alert(token)
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('/').'/api/update-fcm-token' }}",
                type:'POST',
                data: {         
                    "user_id": '2', 
                    "token": token, 
                    "device_type": "desktop",
                    "device_id": navigator.userAgent,                  
                },
                success:function(data, status){
                    // console.log(data)   
                    // alert(data.message);   
                },
            });

        }).catch(function (err) {
            // console.log(err);
        });
    }

    // initFirebaseMessagingRegistration(user_id);

    if (!("Notification" in window)) {
        // Check if the browser supports notifications
        alert("This browser does not support desktop notification");
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
        alert("You need to give notifications permission for this browser");
    }

    // messaging.onMessage(function({data:{body,title}}){
    //     new Notification(title, {body});
    // });

    messaging.onMessage(function(payload) {
        // alert(payload.data.click_action);
        // console.log(payload);
        var title = payload.data.title;
        var options = {
            body: payload.data.body,
            icon: payload.data.icon,
            data: {
                time: new Date(Date.now()).toString(),
                click_action: payload.data.click_action
            }
        };
        var myNotification = new Notification(title, options);
    });

</script>

</body>
</html>
