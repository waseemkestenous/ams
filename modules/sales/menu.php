<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_sales'),null,'file-invoice-dollar','gro');
	$menuy = $modulename . '-' . 'salesbills';
	build_menu($menux ,$menuy,T('_sales_bills'),'mod=' . $modulename . '&page=salesbills');
	$menuy = $modulename . '-' . 'basalesbills';
	build_menu($menux ,$menuy,T('_basales_bills'),'mod=' . $modulename . '&page=basalesbills');
	$menuy = $modulename . '-' . 'saleslines';
	build_menu($menux ,$menuy,T('_saleslines'),'mod=' . $modulename . '&page=saleslines');	
	$menuy = $modulename . '-' . 'salesreps';
	build_menu($menux ,$menuy,T('_salesreps'),'mod=' . $modulename . '&page=salesreps');	
	$menuy = $modulename . '-' .'customers';
	build_menu($menux ,$menuy,T('_customers'),'mod=' . $modulename . '&page=customers');

}
