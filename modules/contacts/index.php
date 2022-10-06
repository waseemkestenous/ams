<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("link-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }' . "\n";
echo '</script>'."\n";

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
    $conditions = array('contact_co_id' => $_SESSION['co_id']);
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($entity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=dash";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

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
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
        header("Location:" . $link);die();   
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
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($entity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$entity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($entity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $entity['tablename'];// Required
    $key = $entity['idname'];//Optional
    $title = $entity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
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
            //check record tables relations
            $check = check_record_relation($entity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
                confirm_del($entity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($entity['titlename'],$entity['tablefields'][$entity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
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
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
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
            check_length_edit_field('contact_name', $data['contact_name'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('contact_name', $data['contact_name'], $entity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_edit_field('contact_email', $data['contact_email'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_tel', $data['contact_tel'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_address', $data['contact_address'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
                confirm_edit($entity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($entity, $data,$form_code,$link,$cancelaction);
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
            check_length_add_field('contact_name', $entity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('contact_name', $entity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));        
            check_add_field('contact_email', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_tel', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_address', $entity, $fields, $fields_temp, $check, $checkerror);

            add_default_field('contact_co_id', $entity , $fields, $fields_temp);
            add_default_field('contact_user_id', $entity , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
                confirm_add($entity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($entity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
    print_add_record($entity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}