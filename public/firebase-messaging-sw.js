/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
  apiKey: "AIzaSyCdSzlzTyuw1sbG9YrWEJ9nX15JvtROwN4",
  authDomain: "makeuart-29386.firebaseapp.com",
  projectId: "makeuart-29386",
  storageBucket: "makeuart-29386.appspot.com",
  messagingSenderId: "556015602848",
  appId: "1:556015602848:web:91851e2dedcb311fa94dc5",
  measurementId: "G-1EFWRBCYE3"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  var title = payload.data.title;
  var options = {
    body: payload.data.body,
    icon: payload.data.icon,
    data:{
      time: new Date(Date.now()).toString(),
      click_action: payload.data.click_action,
    }
  }; 
  return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function(event){
  var action_click = event.notification.data.click_action;
  event.notification.close();

  event.waitUntil(
    clients.openWindow(action_click)
  );
});