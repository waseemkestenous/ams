<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_companies'),'?mod=companies','building','item');
