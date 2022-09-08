<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/bills/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_sells_and_purchases,null,'file-invoice-dollar','gro');
build_menu($menux ,$menuy,_sells,'?mod=bills&page=sells');
$menuy++;
build_menu($menux ,$menuy,_purchases,'?mod=bills&page=purchases');