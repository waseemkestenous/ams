<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;
build_menu($menux, $menuy, '_users_managment','mod=users','user-lock','item');
