<?php
function get_user_by_id($userid) {
    global $conn;
    global $sqltxt;

    $sql = "SELECT * FROM `users` Where `user_id` = " . $userid . ";";

$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;

    $result = $conn->query($sql);
    if (!empty($result)) {
        $row = $result->fetch_assoc();
    } 

    return $row;
}
//var_dump(get_session_by_id(1));
function user_log($sessionid,$activity) {
    global $conn;
    global $sqltxt;
    global $currenttime;

    // close any session for userid
    $sql = "INSERT INTO `user_log` (`user_log_session_id`, `user_log_timestamp`, `user_log_data`) VALUES ('". $sessionid . "', '" . $currenttime . "', '" . $activity . "');";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);

    return true;
}
//user_log(1,'logout');
function user_login($user, $pass) {
    global $conn;
    global $sqltxt;
    // check username and pass in db and get user_id
    //if($user =="admin" && $pass == "123456") $userid = 1; else $userid = 0;
    $sql = "SELECT `user_id` FROM `users` Where `user_username` = '" . $user . "' and `user_password` = '" . $pass . "';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    if (!empty($row)) {
            $userid = $row['user_id'];
    }

    return $userid;
}
//echo user_login('admin','123456');
function open_session($userid) {
    global $conn;
    global $sqltxt;
    global $currenttimestamp;
    global $currenttime;

    // close any session for the same user
    close_session_by_userid($userid);
    // open new session and return user session info
    $sql = "INSERT INTO `sessions` (`user_id`, `session_start_timestamp`, `session_close`, `session_lastact_timestamp`, `session_info`) VALUES ('". $userid . "', '" . $currenttime . "', '0', '" . $currenttime . "', MD5('" . $currenttimestamp . "'));";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);
    $sessionid = $conn->insert_id; 
    $session = get_session_by_id($sessionid);

    return $session;
}
//open_session(1);
function close_session_by_userid($userid) {
    global $conn;
    global $sqltxt;
    
    // close any session for userid
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `user_id` = " . $userid . ";";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);

    return true;
}
//close_session_by_userid(1);
function update_session_by_sessioninfo($sessioninfo) {
    global $conn;
    global $sqltxt;
    global $currenttime;
   
    // close any session for sessioninfo
    $sql = "UPDATE `sessions` SET `session_lastact_timestamp` = '" . $currenttime . "' WHERE `session_info` = '" . $sessioninfo . "';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);

    return true;
}
//update_session_by_sessioninfo('c4ca4238a0b923820dcc509a6f75849b');
function close_session_by_sessioninfo($sessioninfo) {
    global $conn;
    global $sqltxt;
    
    // close any session for sessioninfo
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_info` = '" . $sessioninfo . "';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);

    return true;
}
//close_session_by_sessioninfo('c4ca4238a0b923820dcc509a6f75849b');
function close_expire_sessions() {
    global $conn;
    global $sqltxt;
    global $session_timeout;
    global $lastactivite_timeout;    
    global $currenttimestamp;

    $date = new DateTime();
    $lastactivite = date("Y-m-d H:i:s",$currenttimestamp-$lastactivite_timeout);
    $lastsession = date("Y-m-d H:i:s",$currenttimestamp-$session_timeout);
    // close any session expired depend system setting
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_start_timestamp` < '" . $lastsession . "' or `session_lastact_timestamp` < '" . $lastactivite . "';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);   
    return true;
}
//close_expire_sessions();
function close_session_by_sessionid($sessionid) {
    global $conn;
    global $sqltxt;
    // close any session for sessionid    
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_id` = " . $sessionid . ";";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);
    
    return true;
}
//close_session_by_sessionid(1);
function check_session_open_by_info($sessioninfo) {
    global $conn;
    global $sqltxt;
    
    $sql = "SELECT `session_id` FROM `sessions` Where `session_info` = '" . $sessioninfo . "' and `session_close` = '0';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);
    $session = $result->fetch_assoc(); 
    if (!empty($session)) 
        return true;
    else
        return false;
}
//var_dump(check_session_open_by_info('c4ca4238a0b923820dcc509a6f75849b'));
function get_session_by_info($sessioninfo) {
    global $conn;
    global $sqltxt;

    $sql = "SELECT * FROM `sessions` Where `session_info` = '" . $sessioninfo . "';";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 

    return $row;
}
//var_dump(get_session_by_info('c4ca4238a0b923820dcc509a6f75849b'));
function get_session_by_id($sessionid) {
    global $conn;
    global $sqltxt;

    $sql = "SELECT * FROM `sessions` Where `session_id` = " . $sessionid . ";";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);
    if (!empty($result)) {
        $row = $result->fetch_assoc();
    } 

    return $row;
}
//var_dump(get_session_by_id(1));
function get_user_permission($userid) {
    global $conn;
    global $sqltxt;

    $sql = "SELECT `perm_id` FROM `user_perms` Where `user_id` = " . $userid . ";";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);
    $perm = array();
    if (!empty($result)) {

        while($row = $result->fetch_assoc()) {
            $perm[] = $row['perm_id'];
        }
    }

    return $perm;
}
//var_dump(get_user_permission(1));
function get_permission_list() {
    global $conn;
    global $sqltxt;

    $sql = "SELECT `perm_id`,`perm_name` FROM `permissions`;";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $result = $conn->query($sql);
    $perms= array();
    if (!empty($result)) {
        
        while($row = $result->fetch_assoc()) {
            
            $perms[$row['perm_name']] = $row['perm_id'];
        }
    }

    return $perms;
}
//var_dump(get_permission_list());
function log_request() {
    global $conn;
    global $sqltxt;
    
    if(!isset($_SERVER['REMOTE_ADDR'])) $_SERVER['REMOTE_ADDR'] = '';
    if(!isset($_SERVER['QUERY_STRING'])) $_SERVER['QUERY_STRING'] = '';
    if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = '';
    if(!isset($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT'] = '';

    $sql = "INSERT INTO `logs` (`REMOTE_ADDR`, `QUERY_STRING`, `HTTP_REFERER`, `HTTP_USER_AGENT`) VALUES ('" . $_SERVER['REMOTE_ADDR']. "', '" . $_SERVER['QUERY_STRING']. "', '" . $_SERVER['HTTP_REFERER']. "', '" . $_SERVER['HTTP_USER_AGENT']. "');";
$sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
    $conn->query($sql);

    return true;
}