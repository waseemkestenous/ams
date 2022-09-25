<?php
function get_user_parent($user_id){
	$records = get_records('users','', array('user_user_id'), array('user_id' => $user_id));
	if(!empty($records)) $pid = $records[1]['user_user_id'];

	return $pid;
}
/*function print_workspace_selector(){
    print_open_xpanel_container("_select_workspace",true,"workspace");
	print_open_form('');

	print_ln_solid();
    print_close_form();
    print_close_xpanel_container();
}
function print_workspace_selector(){
	global $currentuserid , $user;
	$id = 6;
	$tablename = 'usercompanies_view';// Required
    $key = 'co_id';//Optional
    if($user['user_usertype_id'] == 1) $conditions = array(); 
    else $conditions = array('userco_user_id'=>$currentuserid, 'userco_lock'=> 0, 'co_lock'=> 0); 
    $tablefields = array('co_id','co_name');
    $data = get_records($tablename, $key, $tablefields, $conditions);
	echo '<br><div id="space" class="btn-group" style="width: 100%;">';
	echo '<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false">';
	echo T('_select_workspace')."&nbsp;&nbsp;";
	echo '</button>';
	echo '<div class="dropdown-menu" style="text-align:right; width:100%">';
    foreach ($data as $ind => $value) {
    	echo '<a class="dropdown-item" href="?index.php?hash="' . encrypturl('mod=companies&page=dash&id=' . $ind . '&action=space') . '>' . $value['co_name'] . '</a>';
    }
	echo '</div>';
	echo '</div>';
}*/