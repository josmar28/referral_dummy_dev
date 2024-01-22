<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.2/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.7.2/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAA0MZrj67kR854imtRbgKXjKxlzi6NSrA",
    authDomain: "dale-1341.firebaseapp.com",
    projectId: "dale-1341",
    storageBucket: "dale-1341.appspot.com",
    messagingSenderId: "657255384059",
    appId: "1:657255384059:web:fdff9bdeab51fae8fa415e",
    measurementId: "G-XK4662239Z"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>