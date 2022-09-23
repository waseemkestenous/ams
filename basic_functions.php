<?php
function log_request() {
    global $conn;
    
    if(!isset($_SERVER['REMOTE_ADDR'])) $_SERVER['REMOTE_ADDR'] = '';
    if(!isset($_SERVER['QUERY_STRING'])) $_SERVER['QUERY_STRING'] = '';
    if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = '';
    if(!isset($_SERVER['HTTP_USER_AGENT'])) $_SERVER['HTTP_USER_AGENT'] = '';

    $sql = "INSERT INTO `logs` (`REMOTE_ADDR`, `QUERY_STRING`, `HTTP_REFERER`, `HTTP_USER_AGENT`) VALUES ('" . addslashes($_SERVER['REMOTE_ADDR']) . "', '" . addslashes($_SERVER['QUERY_STRING']) . "', '" . addslashes($_SERVER['HTTP_REFERER']) . "', '" . addslashes($_SERVER['HTTP_USER_AGENT']) . "');";

    $conn->query($sql);
    
    log_sql($sql);
    
    return true;
}

function user_login($user, $pass) {
    global $conn;

    $sql = "SELECT `user_id` FROM `users` Where `user_username` = '" . addslashes($user) . "' and `user_password` = '" . addslashes($pass) . "' and `user_lock` = 0;";

    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    if (!empty($row)) {
            $userid = $row['user_id'];
    } else $userid = 0;

    log_sql($sql);
    
    return $userid;
}

function user_log($sessionid,$activity) {
    global $conn;
    global $currenttime;

    $sql = "INSERT INTO `userlogs` (`userlog_session_id`, `userlog_timestamp`, `userlog_data`) VALUES ('". addslashes($sessionid) . "', '" . addslashes($currenttime) . "', '" . addslashes($activity) . "');";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function check_session_open_by_info($sessioninfo) {
    global $conn;
    
    $sql = "SELECT `session_id` FROM `sessions` Where `session_info` = '" . addslashes($sessioninfo) . "' and `session_close` = '0';";

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

    $sql = "INSERT INTO `sessions` (`session_user_id`, `session_start_timestamp`, `session_close`, `session_lastact_timestamp`, `session_info`) VALUES ('". addslashes($userid) . "', '" . addslashes($currenttime) . "', '0', '" . addslashes($currenttime) . "', MD5('" . addslashes($currenttimestamp) . "'));";

    $conn->query($sql);
    $rowid = $conn->insert_id; 
    $row = get_session_by_id($rowid);

    log_sql($sql);

    return $row;
}

function update_session_by_sessioninfo($sessioninfo) {
    global $conn;
    global $currenttime;
   
    $sql = "UPDATE `sessions` SET `session_lastact_timestamp` = '" . addslashes($currenttime) . "' WHERE `session_info` = '" . $sessioninfo . "';";

    log_sql($sql);

    if($result =  $conn->query($sql))
        return true;
    else 
        return false;
}

function get_session_by_info($sessioninfo) {
    global $conn;

    $sql = "SELECT * FROM `sessions` Where `session_info` = '" . addslashes($sessioninfo) . "';";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc(); 

    log_sql($sql);

    return $row;
}

function get_session_by_id($sessionid) {
    global $conn;

    $sql = "SELECT * FROM `sessions` Where `session_id` = " . addslashes($sessionid) . ";";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    log_sql($sql);

    return $row;
}

function close_session_by_sessionid($sessionid) {
    global $conn;

    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_id` = " . addslashes($sessionid) . ";";

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

    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_start_timestamp` < '" . addslashes($lastsession) . "' or `session_lastact_timestamp` < '" . addslashes($lastactivite) . "';";

    $conn->query($sql);   

    log_sql($sql);

    return true;
}

function close_session_by_userid($userid) {
    global $conn;
    
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_user_id` = " . $userid . ";";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function close_session_by_sessioninfo($sessioninfo) {
    global $conn;
    
    $sql = "UPDATE `sessions` SET `session_close` = '1' WHERE `session_info` = '" . addslashes($sessioninfo) . "';";

    $conn->query($sql);

    log_sql($sql);

    return true;
}

function log_sql($sql = '') {
    global $sqltxt;

    $sqltxt = $sqltxt . "<br>" . "SQL : " . $sql;
}

function T($text){
    if(!empty($text) && defined($text)) {
        eval('$text = ' . $text .';'); 
    }
    return $text;
}