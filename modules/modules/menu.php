<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

$menux = $modulename;
$menuy = '';	
build_menu($menux ,$menuy,T('_modules'),'mod=' . $modulename,'file-code','item');
