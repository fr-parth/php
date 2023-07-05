$facebook = new Facebook(…);
 $session = $facebook->getSession();
 if ($session) {
   // proceed knowing you have a valid user session
 } else {
   // proceed knowing you require user login and/or authentication
 }

 $facebook = new Facebook(…);
 $user = $facebook->getUser();
 if ($user) {
   // proceed knowing you have a logged in user who's authenticated
 } else {
   // proceed knowing you require user login and/or authentication
 }