<?php
#######################
#Post-Login-On-Facebook-Php-Sdk-4
#filename: index.php
#marco.bore@gmail.com
#######################
require_once 'vendor/autoload.php';
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
session_start();
// init app with app id and secret
FacebookSession::setDefaultApplication(FB_APP_ID,FB_APP_SECRET);

// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper(HTTP_PROJECT_PATH);

if(isset( $_SESSION) && isset( $_SESSION['TOKEN'])){
    $session = new FacebookSession($_SESSION['TOKEN']);
    // To validate the session:
    try {
      $session->validate();
    } catch (FacebookRequestException $ex) {
      // Session not valid, Graph API returned an exception with the reason.
      echo $ex->getMessage();
    } catch (\Exception $ex) {
      // Graph API returned info, but it may mismatch the current app or have expired.
      echo $ex->getMessage();
    }
}

if(!isset($session ) || $session === NULL){
    #Try to catch the session from the fecabook redirect 
    try {
      $session = $helper->getSessionFromRedirect();
    } catch( FacebookRequestException $ex ) {
      // When Facebook returns an error
      print_r( $ex );
    } catch( Exception $ex ) {
      // When validation fails or other local issues
      print_r( $ex );
    }
}

if(isset($session)){
 $request = new FacebookRequest( $session, 'GET', '/me' );
 $response = $request->execute();
 // get response
 $graphObject = $response->getGraphObject();
 $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
 $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
 $_SESSION['FBID'] = $fbid;           
 $_SESSION['FULLNAME'] = $fbfullname;
 $_SESSION['EMAIL'] =  $femail;
 $_SESSION['TOKEN'] = $session->getToken();

 header('location: app.php');

}else{
//stampa la pagina con il login
    $permissions = array(
    'email',
    'user_location',
    'user_birthday',
    'publish_actions'
    );

    $loginUrl = $helper->getLoginUrl($permissions);
    echo '
    <div style="text-align:center">
    <h1>CeccoInspire</h1>
    <h2>"Post on facebook your status"</h2>
    You have been selected to test this application! Now you are an official tester!<br/>
    Login and clik on the \'Ok\' button even if you see errors from Facebook.</br><br/>
    <a href="'.$loginUrl.'">Login with Facebook</a><br/>
    <br/><br><br>
    <h5>Crafted with crime <br/> Marco Boretto marco.bore at gmail.com</h5>
    ';
}

?>
