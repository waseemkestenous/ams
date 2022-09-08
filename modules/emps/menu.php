<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/emps/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_emps_managment,null,'people-group','gro');
build_menu($menux ,$menuy,_emps,'?mod=emps&page=list');