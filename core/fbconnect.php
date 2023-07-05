<?php
require_once 'src/facebook.php'; //include the facebook php sdk
$facebook = new Facebook(array(
        'appId'  => '523355671131002',    //app id
        'secret' => '35c5153fe7dc6893a0cbe2f0d6c46cd7', // app secret
));
$user = $facebook->getUser();
if ($user) { // check if current user is authenticated
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');  //get current user's profile information using open graph
            }
         catch(Exception $e){}
}
/*- See more at: http://excellencemagentoblog.com/facebook-login-integration-website#sthash.Qw19bCMY.gcDiGOzJ.dpuf*/
?>