<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/users/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_users_managment,'?mod=users&page=list','user-lock','item');
