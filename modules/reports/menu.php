<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux,$menuy,T('_reports'),null,'file-pdf','gro');
	$menuy = $modulename . 'reports';	
	build_menu($menux,$menuy,T('_reports'),'mod=' . $modulename);
}
