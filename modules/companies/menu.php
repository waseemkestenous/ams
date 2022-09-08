<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/companies/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_companies,'?mod=companies&page=list','building','item');
