<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_emps_managment'),null,'people-group','gro');
	$menuy = $modulename . 'emps';
	build_menu($menux ,$menuy,T('_emps'),'mod=' . $modulename);
}
