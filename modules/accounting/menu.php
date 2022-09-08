<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/accounting/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_accounting,null,'calculator','gro');
build_menu($menux ,$menuy,_accounting,'?mod=accounting&page=summary');