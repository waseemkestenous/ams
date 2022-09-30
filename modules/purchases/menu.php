<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_purchases'),null,'cart-shopping','gro');
	$menuy = $modulename . 'suppliers';	
	build_menu($menux ,$menuy,T('_suppliers'),'mod=' . $modulename . '&page=suppliers');
	$menuy = $modulename . 'purchasesbills';
	build_menu($menux ,$menuy,T('_purchases_bills'),'mod=' . $modulename . '&page=purchasesbills');
}
