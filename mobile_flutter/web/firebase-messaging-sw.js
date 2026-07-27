importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js");

firebase.initializeApp({
  apiKey: "AIzaSyC5OAH9DtlwjRYHxk168o90tP_YlB5rgS8",
  authDomain: "education-familiale-fire-6f7f2.firebaseapp.com",
  projectId: "education-familiale-fire-6f7f2",
  storageBucket: "education-familiale-fire-6f7f2.firebasestorage.app",
  messagingSenderId: "509560948505",
  appId: "1:509560948505:web:df0710b7b46114cda26788",
});

const messaging = firebase.messaging();