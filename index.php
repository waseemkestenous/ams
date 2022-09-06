<?php
ob_start();
session_start();
$date = new DateTime();
$currenttimestamp = $date->getTimestamp();
$currenttime = date("Y-m-d H:i:s", $currenttimestamp);

include "config.php";
include "lang/" . $lang . ".php";
include "basic_functions.php";
log_request();
// close any expired sessions
close_expire_sessions();
if(isset($_SESSION["login"]) && $_SESSION["login"] <> "LOGIN_ERROR") {
   // check current user session opened 
    $session_exist = check_session_open_by_info($_SESSION["login"]);
} else{
    $session_exist = false;
}

if($session_exist) {
    // get current user id using open user session info
    update_session_by_sessioninfo($_SESSION["login"]);
    $session = get_session_by_info($_SESSION["login"]);
    if(!empty($session)) $currentuserid = $session["user_id"]; else die();
    
    // get current user using current userid
    $user = get_user_by_id($currentuserid);

    // include requird functions
    include "functions.php";

    if (isset($_GET['page'])){
        $page = $_GET['page'];
    } else {
        $page = 'home';
    }
    if($page == "logout") {
        include "logout.php";
    } else {
        include "header.php";
        include "sidebar.php";
        include "top.php";
        include "content.php";
        include "footer.php";
    }
} else {
    if(isset($_GET['page']) and $_GET['page'] == "check") {
        include "check.php";
    } else {
        include "login.php";
    }
}

