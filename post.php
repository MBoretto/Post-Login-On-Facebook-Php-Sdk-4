<?php
#######################
#Post-Login-On-Facebook-Php-Sdk-4
#filename: post.php
#marco.bore@gmail.com
#######################

session_start();
require_once('vendor/autoload.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

FacebookSession::setDefaultApplication(FB_APP_ID,FB_APP_SECRET);

// If you already have a valid access token:
$session = new FacebookSession($_SESSION['TOKEN']);
$messages = array();

// To validate the session:
try {
    $session->validate();
} catch (FacebookRequestException $ex) {
    // Session not valid, Graph API returned an exception with the reason.
    $messages[] = $ex->getMessage();
} catch (\Exception $ex) {
    // Graph API returned info, but it may mismatch the current app or have expired.
    $messages[] = $ex->getMessage();
}

if(isset($session)){

#   echo '<pre>';
#   print_r($_POST);
#   print_r($_SESSION);
#   echo '</pre>';

   $_POST['link'] = trim($_POST['link']);
   $_POST['text'] = trim($_POST['text']);

    if(!empty($_POST['link']) | !empty($_POST['text'])){
        try {
            $request = new FacebookRequest(
            $session, 'POST', '/me/feed', array(
              'link' => $_POST['link'],
              'message' => $_POST['text'],
              'value' => 'SELF'
            ));
            $response = $request->execute();
        } catch(FacebookRequestException $e) {
            $messages[] =    "Exception occured, code: ". $e->getCode()." with message: ". $e->getMessage();
        }   
    }

    if(empty($mesages)){
        $_SESSION['MESSAGES'] = $messages;
    }else{
        $messages[] = 'Campi vuoti';
    }
    header("Location: app.php");

}else{
    header("Location: index.php");
}




?>
