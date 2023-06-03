<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("gro-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("active"); }'."\n";

echo 'link = document.getElementById("ulgro-' . $mod . '");' . "\n";
echo 'if(link) { link.style = "display:block;" }'."\n";

echo 'link = document.getElementById("link-' . $mod . '-' . $page . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }'."\n";
echo '</script>'."\n";

if(isset($checkinsentity['allowview'])) $allow['view'] = $checkinsentity['allowview']; else $allow['view'] = False;
if(isset($checkinsentity['allowedit'])) $allow['edit'] = $checkinsentity['allowedit']; else $allow['edit'] = False;
if(isset($checkinsentity['allowadd'])) $allow['add'] = $checkinsentity['allowadd']; else $allow['add'] = False;
if(isset($checkinsentity['allowdel'])) $allow['del'] = $checkinsentity['allowdel']; else $allow['del'] = False;
if(isset($checkinsentity['allowlock'])) $allow['lock'] = $checkinsentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    $conditions = array('checkin_co_id' => $_SESSION['co_id']);
    if(isset($checkinsentity['tablefields'])) $tablefields = array_keys($checkinsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($checkinsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=checkins";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($checkinsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    if(isset($checkinsentity['tablefields'])) $tablefields = array_keys($checkinsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'checkin_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($checkinsentity['tablename'], array($checkinsentity['lockname'] => $act), array($checkinsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
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
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    if(isset($checkinsentity['tablefields'])) $tablefields = array_keys($checkinsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'checkin_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($checkinsentity['tablename'], array($checkinsentity['lockname'] => $act), array($checkinsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    $checkinsentity['tablefields']['checkin_date']['type'] ='text';
    if(isset($checkinsentity['tablefields'])) $tablefields = array_keys($checkinsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'checkin_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($checkinsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$checkinsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($checkinsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    $title = $checkinsentity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'checkin_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation($checkinsentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
                confirm_del($checkinsentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($checkinsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($checkinsentity['titlename'],$checkinsentity['tablefields'][$checkinsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $checkinsentity['tablename'];// Required
    $key = $checkinsentity['idname'];//Optional
    $lock = $checkinsentity['lockname'];//Optional
    if(isset($checkinsentity['tablefields'])) $tablefields = array_keys($checkinsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'checkin_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('empcontact_view', 'emp_id', array('emp_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'emp_lock' => false));
    $emps = convert_title_list($records, 'contact_name');
    $checkinsentity['tablefields']['checkin_emp_id'] = array('req' => 1, 'type' => 'list', 'array' => $emps, 'title' => '_emp_name');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('checkin_emp_id', $checkinsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('checkin_timein', $data['checkin_timein'], $checkinsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('checkin_timeout', $data['checkin_timeout'], $checkinsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('checkin_notes', $data['checkin_notes'], $checkinsentity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins'. "&id=" .$id . "&action=view");
                confirm_edit($checkinsentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($checkinsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($checkinsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $checkinsentity['lockname'];//Optional
    $data = array();
    
    $records = get_records('empcontact_view', 'emp_id', array('emp_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'emp_lock' => false));
    $emps = convert_title_list($records, 'contact_name');
    $checkinsentity['tablefields']['checkin_emp_id'] = array('req' => 1, 'type' => 'list', 'array' => $emps, 'title' => '_emp_name');
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('checkin_name', $checkinsentity , $fields, $fields_temp, $check, $checkerror);
            check_add_field('checkin_name', $checkinsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('checkin_date', $checkinsentity, $fields, $fields_temp, $check, $checkerror); 
            check_add_field('checkin_notes', $checkinsentity, $fields, $fields_temp, $check, $checkerror); 
            //check co selection.
            add_default_field('checkin_co_id', $checkinsentity , $fields, $fields_temp);
            //check user selection.
            add_default_field('checkin_user_id', $checkinsentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
                confirm_add($checkinsentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($checkinsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'checkins');
    print_add_record($checkinsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}
