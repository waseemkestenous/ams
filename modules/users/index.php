<?php 
if(!isset($currentuserid)) header("Location:index.php");

if($action == 'no') {
    if(!(isset($entity['allowview']) && $entity['allowview'])) header("Location:index.php");

    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if($user['user_type_id'] == 1) $conditions = array();
    else $conditions = array('p_id' => $currentuserid);
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);

    print_open_xpanel_container($entity['pagetitle']);
    print_data_table ($entity, $data, 0);
    print_close_xpanel_container();
} else if($action == 'lock') {
    if(!(isset($entity['allowlock']) && $entity['allowlock'])) header("Location:index.php");

    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_type_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'p_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    if(empty($data)) {
        header("Location:index.php");
        die();
    }

    upd_record($entity['tablename'], array($entity['lockname'] => 1), array($entity['idname'] => $id));
    header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
} else if($action == 'unlock') {
    if(!(isset($entity['allowlock']) && $entity['allowlock'])) header("Location:index.php");

    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_type_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'p_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    upd_record($entity['tablename'], array($entity['lockname'] => 0), array($entity['idname'] => $id));
    header("Location:?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
}else if($action == 'view'){
    if(!(isset($entity['allowview']) && $entity['allowview'])) header("Location:index.php");

    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_type_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'p_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    print_open_xpanel_container($entity['viewpagetitle']);
    print_data_record($entity, $data, true);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!(isset($entity['allowdel']) && $entity['allowdel'])) header("Location:index.php");

    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    $title = $entity['titlename'];//Optional
    $tablefields = array($key,$title);
    if($user['user_type_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'p_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    if(isset($_POST) && !empty($_POST)) {
        $check = true;
        $checkerror =array();
        $exist = check_form();
        if($exist) {
            //check record tables relations
            $check = check_record_relation($tablename, $id, $check);
            if($check) {
                confirm_del($tablename, array($key => $id), 'index.php?mod=' . $mod . '&page=' . $page);
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page . '&id=' . $id . '&action=view');
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['delpagetitle']);
    if(!isset($check)){
        print_del_record($entity,$data[$id],$form_code);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "?mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view";
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){

    if(!(isset($entity['allowedit']) && $entity['allowedit'])) header("Location:index.php");
    
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    $lock = $entity['lockname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    if($user['user_type_id'] == 1) $conditions = array($key => $id);
    else $conditions = array($key => $id,'p_id' => $currentuserid);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");
        die();
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
            check_select_edit_field('user_type_id', $data['user_type_id'], $entity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                confirm_edit($tablename, $fields, array($key => $id), 'index.php?mod='.$mod.'&page='.$page.'&id='.$id.'&action=view');
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page . '&id=' . $id . '&action=view');
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['editpagetitle']);
    print_alert('danger', $checkerror);
    print_edit_record($entity, $data,$form_code, 1);
    print_close_xpanel_container();
}else if($action == 'add'){

    if(!(isset($entity['allowadd']) && $entity['allowadd'])) header("Location:index.php");
    
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
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
            add_default_field('p_id', $entity , $fields, $fields_temp);
            //check user type selection.
            check_select_add_field('user_type_id', $entity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                confirm_add($tablename, $fields, 'index.php?mod=' . $mod . '&page=' . $page);
            }
        } else {
            expire_form('index.php?mod=' . $mod . '&page=' . $page.'&action=add');
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($entity['addpagetitle']);
    print_alert('danger', $checkerror); 
    print_add_record($entity,$data,$form_code, 1);
    print_close_xpanel_container();
}