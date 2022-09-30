<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_sales'),null,'file-invoice-dollar','gro');
	$menuy = $modulename . 'customers';
	build_menu($menux ,$menuy,T('_customers'),'mod=' . $modulename . '&page=customers');
	$menuy = $modulename . 'salesbills';
	build_menu($menux ,$menuy,T('_sales_bills'),'mod=' . $modulename . '&page=salesbills');
}
