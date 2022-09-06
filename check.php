<?php
echo "Check Page";
$_SESSION["login"] = "LOGIN_ERROR";
// check user login data
if(isset($_POST['username']) && isset($_POST['pass'])){
    $userid = user_login($_POST['username'],md5($_POST['pass']));
    if($userid) {
        $session = open_session($userid);
        $_SESSION["login"] = $session['session_info'];
        if($enable_loging) user_log($session['session_id'],'login');
    }
}

if($_SESSION["login"] <> "LOGIN_ERROR" ) {
    header("Location: ?page=home");
} else {
    header("Location:?page=login");
}
die();