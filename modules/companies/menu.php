<?php 
if(!isset($currentuserid)) header("Location:index.php");
$menux = $moduleid;
$menuy = $moduleid;

build_menu($menux ,$menuy,T('_companies'),'mod=companies','building','item');

if($user['user_usertype_id'] <> 1) {
	$tablename = 'usercompanies_view';// Required
	$key = 'co_id';//Optional
	$conditions = array('userco_user_id'=>$currentuserid, 'userco_lock'=> 0, 'co_lock'=> 0); 
	$tablefields = array('co_id','co_name');
	$data = get_records($tablename, $key, $tablefields, $conditions);
	if(isset($_SESSION['co_id'])){
		if(count($data) == 1) {
			$x = array_keys($data);
			build_menu(1,$x[0],$data[$x[0]]['co_name'],'page=list','home','item');
			//build_menu(1,0,T('_home'),'page=list','home','item',0);
			$cocount=1;
		} else {
			if(isset($data[$_SESSION['co_id']])){
				build_menu(1,0,$data[$_SESSION['co_id']]['co_name'],NULL,'home','gro');
				//unset($data[$_SESSION['co_id']]);
			}else {
				unset($_SESSION['co_id']);
				build_menu(1,0,T('_select_workspace'),null,'home','gro');
			}
		}
	} else {
		if(count($data) == 1) {
			$x = array_keys($data);
			$_SESSION['co_id'] = $x[0];
			header("Location:index.php");die();
		}
		build_menu(1,0,T('_select_workspace'),null,'home','gro');
	}
	foreach ($data as $ind => $value) {
		build_menu(1 ,"Co-".$ind,$value['co_name'],'mod=companies&page=dash&id=' . $ind . '&action=space');
	}
} else {
	if(isset($_SESSION['co_id'])){
		$tablename = 'companies';// Required
		$key = 'co_id';//Optional
		$conditions = array(); 
		$tablefields = array('co_id','co_name');
		$data = get_records($tablename, $key, $tablefields, $conditions);
		build_menu(1,$_SESSION['co_id'],$data[$_SESSION['co_id']]['co_name'],'page=list','home','item');
	}
}


