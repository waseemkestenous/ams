<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_sells_and_purchases'),null,'file-invoice-dollar','gro');
build_menu($menux ,$menuy,T('_sells'),'?mod=bills&page=sells');
$menuy++;
build_menu($menux ,$menuy,T('_purchases'),'?mod=bills&page=purchases');