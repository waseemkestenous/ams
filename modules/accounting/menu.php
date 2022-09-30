<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_accounting'),null,'calculator','gro');
	$menuy = $modulename . 'summary';
	build_menu($menux ,$menuy,T('_accounting'),'mod=' . $modulename . '&page=summary');
}
