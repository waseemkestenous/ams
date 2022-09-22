<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_accounting'),null,'calculator','gro');
build_menu($menux ,$menuy,T('_accounting'),'?mod=accounting&page=summary');