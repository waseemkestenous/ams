<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

$menux = $modulename;
$menuy = '';	
build_menu($menux, $menuy, '_users_managment','mod=' . $modulename,'user-lock','item');
