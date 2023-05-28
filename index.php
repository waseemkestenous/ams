<?php
ob_start();
session_start();
$currentdate = getdate();
$currenttimestamp = $currentdate[0];
$currenttime = date("Y-m-d H:i:s", $currenttimestamp);

include "config.php";
include "lang/" . $lang . ".php";
include "basic_functions.php";

if(isset($_GET['hash'])) $url = decrypturl($_GET['hash']);

// Log SERVER Global variable 
log_request();

// close any expired sessions in DB
close_expire_sessions();

// check if there is current Session and it's expiration
if(isset($_SESSION["login"]) && $_SESSION["login"] <> "LOGIN_ERROR") {
   // check current user session expiration 
    $session_exist = check_session_open_by_info($_SESSION["login"]);
} else
    $session_exist = false;

if($session_exist) {
    // include requird functions
    include "functions.php";

    close_expire_forms();
    update_session_by_sessioninfo($_SESSION["login"]);
    
    $session = get_session_by_info($_SESSION["login"]);
    
    if(!empty($session)) 
        $currentuserid = $session["session_user_id"]; 
    else 
        die();
    
    // get current user using current userid
    $records = get_records('users', 'user_id', array(), array('user_id' => $currentuserid));
    $user = $records[$currentuserid]; 
    $user['user_profile_pic'] = 'assets/gentela/production/images/user.png';

    $records = get_records('usertypes', 'usertype_id'); 
    $usertype = convert_title_list($records, 'usertype_title');
    $allowed_usertype_id = array_keys($usertype);
    
    $menu = array();
    build_menu('home',0,T('_home'),'page=list','home','item',0);
    $menusort[0] = 'home';

    $modules = scandir('modules');
    unset($modules[0]);
    unset($modules[1]);

    $related_tables = array();
    $homecode = array();
    $header_code = array(); 
    $header_code_st = "";
    $header_code_end = "";
    $footer_code = array();    
    $footer_code_st = "";
    $footer_code_end = "";
    
    $enabledmodules = array();

    $basicmodules = get_records('modules', 'module_name',array(),array('module_basic' => 1,'module_lock' => 0)); 
    $basicmodulesorder = 10000;
    foreach ($basicmodules as $ind => $value) {
        $basicmodules[$ind]['comodule_order'] = $basicmodulesorder;
        $basicmodulesorder++;
    }
    //var_dump($basicmodules);

    foreach ($basicmodules as $modulename => $value) {
        $req_modules = array();
        
        $allowed_usertype_id = array_keys($usertype);

        // load module basic lang files
        if(file_exists("modules/" . $modulename . "/basic_lang/" . $lang . ".php")) 
            include "modules/" . $modulename . "/basic_lang/" . $lang . ".php";
        else if(file_exists("modules/" . $modulename . "/basic_lang/en.php")) 
            include "modules/" . $modulename . "/basic_lang/en.php";

        // include module func file
        if(file_exists("modules/" . $modulename . "/functions.php")) 
            include "modules/" . $modulename . "/functions.php";

        $var_file_path = 'modules/' . $modulename . '/var.php';
        if(file_exists($var_file_path)) 
            include($var_file_path);

        $mods[$modulename]['req_modules'] = $req_modules;
        $mods[$modulename]['allowed_usertype_id'] = $allowed_usertype_id; 

        $menu_file_path = 'modules/' . $modulename . '/menu.php';
        if(file_exists($menu_file_path)) 
            include($menu_file_path);
    }

    foreach ($enabledmodules as $modulename => $value) {
        $req_modules = array();
        
        $allowed_usertype_id = array_keys($usertype);

        // load module basic lang files
        if(file_exists("modules/" . $modulename . "/basic_lang/" . $lang . ".php")) 
            include "modules/" . $modulename . "/basic_lang/" . $lang . ".php";
        else if(file_exists("modules/" . $modulename . "/basic_lang/en.php")) 
            include "modules/" . $modulename . "/basic_lang/en.php";

        // include module func file
        if(file_exists("modules/" . $modulename . "/functions.php")) 
            include "modules/" . $modulename . "/functions.php";

        $var_file_path = 'modules/' . $modulename . '/var.php';
        if(file_exists($var_file_path)) 
            include($var_file_path);

        $mods[$modulename]['req_modules'] = $req_modules;
        $mods[$modulename]['allowed_usertype_id'] = $allowed_usertype_id; 

        $menu_file_path = 'modules/' . $modulename . '/menu.php';
        if(file_exists($menu_file_path)) 
            include($menu_file_path);
    }

    $enabledmodules = array_merge($enabledmodules, $basicmodules);

    foreach ($enabledmodules as $ind => $value) {
        $menusort[$value['comodule_order']] = $ind;
    }
    ksort($menusort);   
    //var_dump($menusort);

    if (isset($_GET['mod']) && isset($enabledmodules[$_GET['mod']])) $mod = $_GET['mod']; else $mod = 'home';
    if (isset($_GET['page'])) $page = $_GET['page']; else $page = 'dash';
    if(isset($_GET['action'])) $action = $_GET['action']; else $action = 'no';
    
    if($action == "logout") {
        include "logout.php";
    } else {
        
        if(in_array($mod, $modules)) {
            $current_modulename = $mod;
            
            // include module language file
            if(file_exists("modules/" . $current_modulename . "/lang/" . $lang . ".php")) 
                include "modules/" . $current_modulename . "/lang/" . $lang . ".php";
            else if(file_exists("modules/" . $current_modulename . "/lang/en.php")) 
                include "modules/" . $current_modulename . "/lang/en.php";
        
            
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

