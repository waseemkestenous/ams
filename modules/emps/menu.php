<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_emps_managment'),null,'people-group','gro');
build_menu($menux ,$menuy,T('_emps'),'?mod=emps');