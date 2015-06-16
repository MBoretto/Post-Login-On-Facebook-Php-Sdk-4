<?php 
#######################
#Post-Login-On-Facebook-Php-Sdk-4
#filename: logout.php
#marco.bore@gmail.com
#######################

session_start();
session_unset();
$_SESSION['FBID'] = NULL;
$_SESSION['FULLNAME'] = NULL;
$_SESSION['EMAIL'] =  NULL;
$_SESSION['TOKEN'] = NULL;
$_SESSION['MESSAGES'] = NULL;
header("Location: index.php");     
?>
