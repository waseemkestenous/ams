<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if(isset($_SESSION['co_id'])){
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux , $menuy,T('_stores_managment'),null,'cubes-stacked','gro');

	$menuy = $modulename . '-stores';
	build_menu($menux , $menuy ,T('_stores'),'mod=' . $modulename);	
	$menuy = $modulename . '-cats';
	build_menu($menux , $menuy,T('_categories'),'mod=' . $modulename . '&page=cats');
	$menuy = $modulename . '-items';
	build_menu($menux , $menuy,T('_items'),'mod=' . $modulename . '&page=items');
	$menuy = $modulename . '-losses';
	build_menu($menux , $menuy,T('_losses'),'mod=' . $modulename . '&page=losses');
	$menuy = $modulename . '-stock';
	build_menu($menux , $menuy,T('_stock'),'mod=' . $modulename . '&page=stock');
}
