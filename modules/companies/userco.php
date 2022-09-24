<?php 
if(!isset($currentuserid)){    
    header("Location:index.php");die();
}
check_perms();

if(isset($subentity['allowview'])) $suballow['view'] = $subentity['allowview']; else $suballow['view'] = False;
if(isset($subentity['allowedit'])) $suballow['edit'] = $subentity['allowedit']; else $suballow['edit'] = False;
if(isset($subentity['allowadd'])) $suballow['add'] = $subentity['allowadd']; else $suballow['add'] = False;
if(isset($subentity['allowdel'])) $suballow['del'] = $subentity['allowdel']; else $suballow['del'] = False;
if(isset($subentity['allowlock'])) $suballow['lock'] = $subentity['allowlock']; else $suballow['lock'] = False;

if($action == 'lock') {
    $act = 1;
	if(!$suballow['lock']){    
        header("Location:index.php");die();
    }
	if(isset($_GET['rel'])){
	    if($_GET['rel'] == 1) $rel = 1; 
	    else $rel = 0;
	}
	$tablename = 'companyusers_view';// Required
	$key = $subentity['idname'];//Optional
	if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $conditions = array($key => $id); 
	$data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
	if(empty($data)) {
	    header("Location:index.php");
	    die();
	}
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos)){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if($data['user_user_id'] <> $currentuserid && $user['user_usertype_id'] <> 1 ) {
        header("Location:index.php");
        die();
    } 
	upd_record($subentity['tablename'], array($subentity['lockname'] => $act), array($subentity['idname'] => $id));
	if($rel == 0) {
        header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view#userslist");die();
    }
	if($rel == 1) {
        header("Location:?mod=" . $mod . "&page=dash&id=". $data['userco_co_id'] ."&action=view#userslist");die();
    }
} else if($action == 'unlock') {
    $act = 0;
    if(!$suballow['lock']){    
        header("Location:index.php");die();
    }
    if(isset($_GET['rel'])){
        if($_GET['rel'] == 1) $rel = 1; 
        else $rel = 0;
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos)){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if($data['user_user_id'] <> $currentuserid && $user['user_usertype_id'] <> 1 ) {
        header("Location:index.php");
        die();
    }   
    upd_record($subentity['tablename'], array($subentity['lockname'] => $act), array($subentity['idname'] => $id));
    if($rel == 0) {
        header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view#userslist");die();
    }
    if($rel == 1) {
        header("Location:?mod=" . $mod . "&page=dash&id=". $data['userco_co_id'] ."&action=view#userslist");die();
    }
}else if($action == 'view'){
    if(!$suballow['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $tablefields[] = 'user_lock'; 
	$conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos)){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        $suballow['lock'] = false;
        $suballow['del'] = false; 
    }
    if(($data['user_user_id'] <> $currentuserid) && ($user['user_usertype_id'] <> 1) ) {
        $suballow['lock'] = false;
        $suballow['del'] = false; 
    }
    if($data['user_lock']) {
        $suballow['lock'] = false;
        $data['userco_lock'] = 1;
    }  
    print_open_xpanel_container($subentity['viewpagetitle']);
    if($suballow['edit'] || $suballow['lock'] || $suballow['del']) {
    	$link = "?mod=" . $mod . "&page=" . $page . "&id=" . $id;
	    if($suballow['edit']) {
	    	print_lbtn($link . "&action=edit", T('_edit'), T('_edit_record'), 'primary', 'pencil');  
	    }
	    if($suballow['lock']) {
	        if($data[$subentity['lockname']]) {  
	            print_lbtn($link . "&action=unlock", T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
	        } else {
	            print_lbtn($link . "&action=lock", T('_lock'), T('_lock_record'), 'dark', 'lock');
	        }
	    }
	    if($suballow['del']) {
	    	print_lbtn($link . "&action=del", T('_delete'), T('_del_record'), 'danger', 'trash-can');
	    }
    	print_ln_solid();
    }
    print_data_record($subentity, $data);
    print_ln_solid();
    print_goback_btn_gro("?mod=" . $mod . "&page=dash&id=" . $data['userco_co_id'] . "&action=view#userslist");
    print_close_xpanel_container();

}else if($action == 'del'){
    if(!$suballow['del']){    
        header("Location:index.php");die();
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    $title = $subentity['titlename'];//Optional
    $tablefields = array($key,'userco_user_id','userco_co_id');
    $tablefields[] = 'user_user_id'; 
    $tablefields[] = 'user_name'; 
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];//var_dump($data);
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos)){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if(($data['user_user_id'] <> $currentuserid) && ($user['user_usertype_id'] <> 1) ) {
        header("Location:index.php");
        die();
    } 
    if(isset($_POST) && !empty($_POST)) {
        $check = true;
        $checkerror =array();
        $exist = check_form();
        if($exist) {
            //check record tables relations
            $check = check_record_relation($subentity['tablename'], $id, $check);
            if($check) {
                confirm_del($subentity['tablename'], array($key => $id), 'index.php?mod=' . $mod . '&page=dash&id='. $data['userco_co_id'] .'&action=view#userslist');
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page . '&id=' . $id . '&action=view');
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($subentity['delpagetitle']);
      
    if(!isset($check)){
        $action = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action;  
        print_del_record($subentity['titlename'],'_user',$data,$form_code,$action,"javascript:history.go(-1)");
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view"; 
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$suballow['add']){    
        header("Location:index.php");die();
    }
    if(!$suballow['add']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = '';//Optional
    $fields = array('co_id');//Optional
    $conditions = array('userco_user_id'=> $currentuserid,'co_lock' => 0); 
    $records = get_records($tablename, $key, $fields, $conditions);
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($id,$mycos)){
        header("Location:index.php");die();
    }
    $lock = $subentity['lockname'];//Optional
    $data = array();
    
    $records = get_records('users', 'user_id', array('user_id','user_name'), array('user_user_id'=>$currentuserid,'user_lock' => 0));
    $myusers = convert_title_list($records, 'user_name');
    $records = get_records('usercompanies', 'userco_id', array('userco_id','userco_user_id'), array('userco_co_id'=>$id));
    $cousers = convert_title_list($records, 'userco_user_id');
    foreach ($myusers as $ind => $value) {
         if(in_array($ind,$cousers)) unset($myusers[$ind]);
     } 

    $subentity['tablefields']['userco_co_id']['default'] = $id;
    $subentity['tablefields']['userco_user_id'] = array('req' => 1, 'type' => 'list', 'array' => $myusers, 'title' => '_user');
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check user type selection.
            check_select_add_field('userco_user_id', $subentity, $fields, $fields_temp, $check, $checkerror);
            if(isset($_POST['userco_user_id'])) {
                $exist = check_record_exist($subentity['tablename'], array('userco_user_id' => $_POST['userco_user_id'],'userco_co_id' => $id));
                if($exist) {
                    $check = false; $checkerror[] = T($subentity['tablefields']['userco_user_id']['title']) . " : " . T('_exist_error');
                }
            } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
                $check = false; 
                $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
            }
            check_add_field('userco_notes', $subentity, $fields, $fields_temp, $check, $checkerror);
            //check user parent selection.
            add_default_field('userco_reguser_id', $subentity , $fields, $fields_temp);
            $subentity['tablefields']['userco_co_id']['default'] = $id;
            add_default_field('userco_co_id', $subentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            if($check) {
                $link = "?mod=" . $mod . "&page=dash&id=". $id . "&action=view#userslist";
                confirm_add($subentity['tablename'], $fields, $link);
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page.'&action=add');
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($subentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $action = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action; 
    $cancelaction = "?mod=" . $mod . "&page=dash&id=". $id . "&action=view#userslist";
    print_add_record($subentity,$data,$form_code,$action,$cancelaction);
    print_close_xpanel_container();

}