<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;
if(isset($_SESSION['co_id'])){
	build_menu($menux,$menuy,T('_reports'),null,'file-pdf','gro');
	build_menu($menux,$menuy,T('_reports'),'mod=reports');
}