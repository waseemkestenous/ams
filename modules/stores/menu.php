<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_stores_managment'),null,'cubes-stacked','gro');
build_menu($menux ,$menuy,T('_categories'),'?mod=stores&page=cats');
$menuy++;
build_menu($menux ,$menuy,T('_items'),'?mod=stores&page=items');
$menuy++;
build_menu($menux ,$menuy,T('_stores'),'?mod=stores');
$menuy++;
build_menu($menux ,$menuy,T('_stock'),'?mod=stores&page=stock');