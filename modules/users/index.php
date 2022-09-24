<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}
check_perms();

if(isset($entity['allowview'])) $allow['view'] = $entity['allowview']; else $allow['view'] = False;
if(isset($entity['allowedit'])) $allow['edit'] = $entity['allowedit']; else $allow['edit'] = False;
if(isset($entity['allowadd'])) $allow['add'] = $entity['allowadd']; else $allow['add'] = False;
if(isset($entity['allowdel'])) $allow['del'] = $entity['allowdel']; else $allow['del'] = False;
if(isset($entity['allowlock'])) $allow['lock'] = $entity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if($user['user_usertype_id'] == 1) $conditions = array();
    else $conditions = array('user_user_id' => $currentuserid);
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($entity['pagetitle']);
    if($allow['add']) {
        $link = "?mod=" . $mod . "&page=" . $page;
        print_lbtn($link . "&action=add", '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "?mod=" . $mod . "&page=dash";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();
    if($currentuserid <> 1) $denyedit[] = 1;
    $denydel[] = 1;   
    $denylock[] = 1;  
    $denydel[] = $currentuserid;   
    $denylock[] = $currentuserid;

    print_data_table ($entity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
    print_close_xpanel_container();
} else if($action == 'lock') {
    $act = 1;
    if(!$allow['lock']) {
        header("Location:index.php");die();
    }
    if(isset($_GET['rel'])){
        if($_GET['rel'] == 1) $rel = 1; 
        else $rel = 0;
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_usertype_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'user_user_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");die();
    }
    if($rel == 1) {
        header("Location:?mod=" . $mod . "&page=" . $page);die();
    }
} else if($action == 'unlock') {
    $act = 0;
    if(!$allow['lock']) {
        header("Location:index.php");die();
    }
    if(isset($_GET['rel'])){
        if($_GET['rel'] == 1) $rel = 1; 
        else $rel = 0;
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_usertype_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'user_user_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");die();
    }
    if($rel == 1) {
        header("Location:?mod=" . $mod . "&page=" . $page);die();
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_usertype_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'user_user_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($entity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        $link = "?mod=" . $mod . "&page=" . $page . "&id=" . $id;
        if($allow['edit']) {
            print_lbtn($link . "&action=edit", T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$entity['lockname']]) {  
                print_lbtn($link . "&action=unlock", T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                print_lbtn($link . "&action=lock", T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            print_lbtn($link . "&action=del", T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($entity, $data);
    print_ln_solid();
    print_goback_btn_gro("?mod=" . $mod . "&page=" . $page);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    $title = $entity['titlename'];//Optional
    $tablefields = array($key,$title);
    if($user['user_usertype_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'user_user_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    if(isset($_POST) && !empty($_POST)) {
        $check = true;
        $checkerror =array();
        $exist = check_form();
        if($exist) {
            if($data['user_id'] == 1) {
                $check = false; 
                $checkerror[] =T('_delete_not_allow_error');             
            }
            //check record tables relations
            $check = check_record_relation($entity['tablename'], $id, $check);
            if($check) {
                confirm_del($entity['tablename'], array($key => $id), 'index.php?mod=' . $mod . '&page=' . $page);
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page . '&id=' . $id . '&action=view');
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['delpagetitle']);
    
    if(!isset($check)){
        $action = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action;  
        print_del_record($entity['titlename'],$entity['tablefields'][$entity['titlename']]['title'],$data,$form_code,$action,"javascript:history.go(-1)");
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view";   
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    $lock = $entity['lockname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_usertype_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'user_user_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_edit_field('user_name', $data['user_name'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check username if alreadt existed if changed
            check_exist_edit_field('user_username', $data['user_username'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check username length  if changed
            check_length_edit_field('user_username', $data['user_username'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check password strength if changed
            check_length_edit_password('user_password', $data['user_password'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check user type selection.
            check_select_edit_field('user_usertype_id', $data['user_usertype_id'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                confirm_edit($entity['tablename'], $fields, array($key => $id), 'index.php?mod='.$mod.'&page='.$page.'&id='.$id.'&action=view');
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page . '&id=' . $id . '&action=view');
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['editpagetitle']);
    print_alert('danger', $checkerror);
    $action = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action;  
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($entity, $data,$form_code,$action,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $entity['lockname'];//Optional
    $data = array();
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('user_name', $entity , $fields, $fields_temp, $check, $checkerror);
            //check username length 
            check_length_add_field('user_username', $entity , $fields, $fields_temp, $check, $checkerror);
            //check username if alreadt existed
            check_exist_add_field('user_username', $entity, $fields, $fields_temp, $check, $checkerror);
            //check password strength if changed
            check_length_add_password('user_password', $entity, $fields, $fields_temp, $check, $checkerror);
            //check user parent selection.
            add_default_field('user_user_id', $entity , $fields, $fields_temp);
            //check user type selection.
            check_select_add_field('user_usertype_id', $entity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                confirm_add($entity['tablename'], $fields, 'index.php?mod=' . $mod . '&page=' . $page);
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page.'&action=add');
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($entity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $action = "?mod=" . $mod . "&page=" . $page . "&action=" . $action; 
    $cancelaction = "?mod=" . $mod . "&page=" . $page;
    print_add_record($entity,$data,$form_code,$action,$cancelaction);
    print_close_xpanel_container();
}