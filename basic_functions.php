<?php
function log_request() {
    global $conn;
    
    if(!isset($_SERVER['REMOTE_ADDR'])) $_SERVER['REMOTE_ADDR'] = '';
    if(!isset($_SERVER['QUERY_STRING'])) $_SERVER['QUERY_STRING'] = '';
    if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = '';
    if(!isset($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT'] = '';

    $sql = "INSERT INTO `logs` (`REMOTE_ADDR`, `QUERY_STRING`, `HTTP_REFERER`, `HTTP_USER_AGENT`) VALUES ('" . $_SERVER['REMOTE_ADDR']. "', '" . $_SERVER['QUERY_STRING']. "', '" . $_SERVER['HTTP_REFERER']. "', '" . $_SERVER['HTTP_USER_AGENT']. "');";

    $conn->query($sql);
    
    log_sql($sql);
    
    return true;
}

function user_login($user, $pass) {
    global $conn;

    $sql = "SELECT `user_id` FROM `users` Where `user_username` = '" . $user . "' and `user_password` = '" . $pass . "';";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    if (!empty($row)) {
            $userid = $row['user_id'];
    } else $userid = 0;

    log_sql($sql);
    
    return $userid;
}

function get_user_by_id($userid) {
    global $conn;

    $sql = "SELECT * FROM `users` Where `user_id` = " . $userid . ";";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    log_sql($sql);

    return $row;
}

function user_log($sessionid,$activity) {
    global $conn;
    global $currenttime;

    $sql = "INSERT INTO `user_log` (`user_log_session_id`, `user_log_timestamp`, `user_log_data`) VALUES ('". $sessionid . "', '" . $currenttime . "', '" . $activity . "');";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function check_session_open_by_info($sessioninfo) {
    global $conn;
    
    $sql = "SELECT `session_id` FROM `sessions` Where `session_info` = '" . $sessioninfo . "' and `session_close` = '0';";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 

    if (!empty($row)) 
        $open = true;
    else
        $open = false;

    log_sql($sql);   

    return $open;
}

function open_session($userid) {
    global $conn;
    global $currenttimestamp;
    global $currenttime;

    close_session_by_userid($userid);

    $sql = "INSERT INTO `sessions` (`user_id`, `session_start_timestamp`, `session_close`, `session_lastact_timestamp`, `session_info`) VALUES ('". $userid . "', '" . $currenttime . "', '0', '" . $currenttime . "', MD5('" . $currenttimestamp . "'));";

    $conn->query($sql);
    $rowid = $conn->insert_id; 
    $row = get_session_by_id($rowid);

    log_sql($sql);

    return $row;
}

function update_session_by_sessioninfo($sessioninfo) {
    global $conn;
    global $currenttime;
   
    $sql = "UPDATE `sessions` SET `session_lastact_timestamp` = '" . $currenttime . "' WHERE `session_info` = '" . $sessioninfo . "';";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function get_session_by_info($sessioninfo) {
    global $conn;

    $sql = "SELECT * FROM `sessions` Where `session_info` = '" . $sessioninfo . "';";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 

    log_sql($sql);

    return $row;
}

function get_session_by_id($sessionid) {
    global $conn;

    $sql = "SELECT * FROM `sessions` Where `session_id` = " . $sessionid . ";";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    log_sql($sql);

    return $row;
}

function close_session_by_sessionid($sessionid) {
    global $conn;

    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_id` = " . $sessionid . ";";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function close_expire_sessions() {
    global $conn;
    global $session_timeout;
    global $lastactivite_timeout;    
    global $currenttimestamp;

    $date = new DateTime();
    $lastactivite = date("Y-m-d H:i:s",$currenttimestamp-$lastactivite_timeout);
    $lastsession = date("Y-m-d H:i:s",$currenttimestamp-$session_timeout);

    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_start_timestamp` < '" . $lastsession . "' or `session_lastact_timestamp` < '" . $lastactivite . "';";

    $conn->query($sql);   

    log_sql($sql);

    return true;
}

function close_session_by_userid($userid) {
    global $conn;
    
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `user_id` = " . $userid . ";";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function close_session_by_sessioninfo($sessioninfo) {
    global $conn;
    
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_info` = '" . $sessioninfo . "';";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function log_sql($sql = '') {
    global $sqltxt;

    $sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
}