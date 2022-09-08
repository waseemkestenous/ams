<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<?php
include('modules/contacts/var.php');
$menuids[$modulename] = $menuid;
$menux = $menuid;
$menuy = $menuid;
build_menu($menux ,0,_suppliers_and_clients,null,'users','gro');
build_menu($menux ,$menuy,_suppliers,'?mod=contacts&page=suppliers');
$menuy++;
build_menu($menux ,$menuy,_clients,'?mod=contacts&page=clients');