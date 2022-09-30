<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}

if($user['user_usertype_id'] <> 1) {
	$tablename = 'usercompanies_view';// Required
	$key = 'co_id';//Optional
	$conditions = array('userco_user_id'=>$currentuserid, 'userco_lock'=> 0, 'co_lock'=> 0); 
	$tablefields = array('co_id','co_name');
	$data = get_records($tablename, $key, $tablefields, $conditions);
	if(isset($_SESSION['co_id'])){
		if(count($data) == 1) {
			$x = array_keys($data);
			build_menu('home',$x[0],$data[$x[0]]['co_name'],'page=list','home','item');
			$cocount=1;
		} else {
			if(isset($data[$_SESSION['co_id']])){
				build_menu('home',0,$data[$_SESSION['co_id']]['co_name'],NULL,'home','gro');
				//unset($data[$_SESSION['co_id']]);
			}else {
				unset($_SESSION['co_id']);
				build_menu('home',0,T('_select_workspace'),null,'home','gro');
			}
		}
	} else {
		if(count($data) == 1) {
			$x = array_keys($data);
			$_SESSION['co_id'] = $x[0];
			header("Location:index.php");die();
		} else if(count($data) > 1) {
			build_menu('home',0,T('_select_workspace'),null,'home','gro');
		}
	}
	foreach ($data as $ind => $value) {
		build_menu('home' ,"Co-".$ind,$value['co_name'],'mod=' . $modulename .'&page=dash&id=' . $ind . '&action=space');
	}
	if(count($data) > 0) {
		$menux = $modulename;
		$menuy = '';	
		build_menu($menux ,$menuy,T('_companies'),'mod=' . $modulename,'building','item');
	}
} else {
	if(isset($_SESSION['co_id'])){
		$tablename = 'companies';// Required
		$key = 'co_id';//Optional
		$conditions = array(); 
		$tablefields = array('co_id','co_name');
		$data = get_records($tablename, $key, $tablefields, $conditions);
		build_menu('home',$_SESSION['co_id'],$data[$_SESSION['co_id']]['co_name'],'page=list','home','item');
	}
	$menux = $modulename;
	$menuy = '';	
	build_menu($menux ,$menuy,T('_companies'),'mod=' . $modulename,'building','item');
}



