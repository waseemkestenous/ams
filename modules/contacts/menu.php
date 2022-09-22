<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_suppliers_and_clients'),null,'users','gro');
build_menu($menux ,$menuy,T('_suppliers'),'?mod=contacts&page=suppliers');
$menuy++;
build_menu($menux ,$menuy,T('_clients'),'?mod=contacts&page=clients');