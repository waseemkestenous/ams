<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_emps_managment'),null,'people-group','gro');
	$menuy = $modulename . '-' . 'emps';
	build_menu($menux ,$menuy,T('_emps'),'mod=' . $modulename . '&page=emps');
	$menuy = $modulename . '-' . 'depts';
	build_menu($menux ,$menuy,T('_depts'),'mod=' . $modulename . '&page=depts');
	$menuy = $modulename . '-' . 'jobs';
	build_menu($menux ,$menuy,T('_jobs'),'mod=' . $modulename . '&page=jobs');
	$menuy = $modulename . '-' . 'holidays';
	build_menu($menux ,$menuy,T('_holidays'),'mod=' . $modulename . '&page=holidays');
}
