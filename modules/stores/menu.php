<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/stores/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_stores_managment,null,'home','gro');
build_menu($menux ,$menuy,_categories,'?mod=stores&page=cats');
$menuy++;
build_menu($menux ,$menuy,_items,'?mod=stores&page=items');
$menuy++;
build_menu($menux ,$menuy,_stores,'?mod=stores&page=list');
$menuy++;
build_menu($menux ,$menuy,_stock,'?mod=stores&page=stock');