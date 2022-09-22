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
    // include requird functions
    include "functions.php";

    close_expire_forms();
    
    // get current user id using open user session info
    update_session_by_sessioninfo($_SESSION["login"]);
    $session = get_session_by_info($_SESSION["login"]);
    if(!empty($session)) $currentuserid = $session["user_id"]; else die();
    
    // get current user using current userid

    $tablename = 'users'; //Required
    $key = 'user_id'; //Optional
    $fields = array(); //Optional
    $conditions = array('user_id' => $currentuserid); //Optional
    $orderfields = array(); //Optional
    $ordertype = ''; //Optional - VALUES # '', 'ASC', 'DESC'

    $records = get_records($tablename, $key, $fields, $conditions, $orderfields, $ordertype);
    $user = $records[$currentuserid]; //var_dump($records);

    $tablename = 'user_types'; //Required
    $key = 'user_type_id'; //Optional
    $fields = array(); //Optional
    $conditions = array(); //Optional
    $orderfields = array(); //Optional
    $ordertype = ''; //Optional - VALUES # '', 'ASC', 'DESC'

    $records = get_records($tablename, $key, $fields, $conditions, $orderfields, $ordertype); 
    $usertype = convert_title_list($records, 'user_type_title'); //var_dump($usertype);

    // build menu from modules
    $menu = array();
    build_menu(1,0,T('_home'),'?page=list','home','item');

    $modules = scandir('modules');
    unset($modules[0]);
    unset($modules[1]);

    if (isset($_GET['mod']) && in_array($_GET['mod'], $modules)) $mod = $_GET['mod']; else $mod = 'home';
    if (isset($_GET['page'])) $page = $_GET['page']; else $page = 'dash';
    if(isset($_GET['action'])) $action = $_GET['action']; else $action = 'no';

    foreach ($modules as $value) {
        // load module basic lang files
        if(file_exists("modules/" . $value . "/basic_lang/" . $lang . ".php")) 
            include "modules/" . $value . "/basic_lang/" . $lang . ".php";
        else if(file_exists("modules/" . $value . "/basic_lang/en.php")) 
            include "modules/" . $value . "/basic_lang/en.php";

        $var_file_path = 'modules/' . $value . '/var.php';
        if(file_exists($var_file_path)) 
            include($var_file_path);
        
        $menu_file_path = 'modules/' . $value . '/menu.php';
        if(file_exists($menu_file_path)) 
            include($menu_file_path);

        $mods[$modulename]['id'] = $moduleid;
        $mods[$modulename]['req_modules'] = $req_modules;
    }
    if($action == "logout") {
        include "logout.php";
    } else {
        $header_code = "";
        $footer_code_st = "";
        $footer_code_end = "";
        if(in_array($mod, $modules)) {
            $current_modulename = $mod;
            
            // include module language file
            if(file_exists("modules/" . $current_modulename . "/lang/" . $lang . ".php")) 
                include "modules/" . $current_modulename . "/lang/" . $lang . ".php";
            else if(file_exists("modules/" . $current_modulename . "/lang/en.php")) 
                include "modules/" . $current_modulename . "/lang/en.php";
            
            // include module func file
            if(file_exists("modules/" . $current_modulename . "/functions.php")) 
                include "modules/" . $current_modulename . "/functions.php";
            
            if(isset($_GET['id'])) $id = $_GET['id']; else $id = 0;
            // include module basic file
            $actionlist = array();
            if(file_exists("modules/" . $current_modulename . "/basic.php")) 
                include "modules/" . $current_modulename . "/basic.php";
            
            if(!in_array($action, $actionlist)) $action = 'no';
        }
        include "header.php";
        include "sidebar.php";
        include "top.php";
        include "content.php";
        include "footer.php";
    }

} else {
    if(isset($_GET['action']) and $_GET['action'] == "check") {
        include "check.php";
    } else {
        include "login.php";
    }
}

