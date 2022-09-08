<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/reports/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux,0,_reports,null,'file-pdf','gro');
build_menu($menux,$menuy,_reports,'?mod=reports&page=list');