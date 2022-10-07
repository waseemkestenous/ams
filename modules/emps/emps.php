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

echo 'link = document.getElementById("link-' . $mod . '-' . 'emps' . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }'."\n";
echo '</script>'."\n";

if(isset($empsentity['allowview'])) $allow['view'] = $empsentity['allowview']; else $allow['view'] = False;
if(isset($empsentity['allowedit'])) $allow['edit'] = $empsentity['allowedit']; else $allow['edit'] = False;
if(isset($empsentity['allowadd'])) $allow['add'] = $empsentity['allowadd']; else $allow['add'] = False;
if(isset($empsentity['allowdel'])) $allow['del'] = $empsentity['allowdel']; else $allow['del'] = False;
if(isset($empsentity['allowlock'])) $allow['lock'] = $empsentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    $conditions = array('contact_co_id' => $_SESSION['co_id']);
    if(isset($empsentity['tablefields'])) $tablefields = array_keys($empsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($empsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=add");
        print_lbtn($link, '_addwithcontact', '_add_record', 'success', 'plus',''); 
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=addfrmcontact");
        print_lbtn($link, '_addfrmcontact', '_add_record', 'success', 'plus','');       
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=emps";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($empsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    if(isset($empsentity['tablefields'])) $tablefields = array_keys($empsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($empsentity['tablename'], array($empsentity['lockname'] => $act), array($empsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
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
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    if(isset($empsentity['tablefields'])) $tablefields = array_keys($empsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($empsentity['tablename'], array($empsentity['lockname'] => $act), array($empsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    if(isset($empsentity['tablefields'])) $tablefields = array_keys($empsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($empsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$empsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($empsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    $title = $empsentity['titlename'];//Optional
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
            $check = check_record_relation('emps', $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
                confirm_del('emps', array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($empsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($empsentity['titlename'],$empsentity['tablefields'][$empsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $empsentity['tablename'];// Required
    $key = $empsentity['idname'];//Optional
    $lock = $empsentity['lockname'];//Optional
    if(isset($empsentity['tablefields'])) $tablefields = array_keys($empsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('jobs', 'job_id', array('job_id','job_name','job_lock'), array('job_co_id' => $_SESSION['co_id']));
    foreach ($records as $ind => $value) {
        if(($ind <> $data['emp_job_id']) && $value['job_lock']) unset($records[$ind]);
    }
    $jobs = convert_title_list($records, 'job_name');
    $empsentity['tablefields']['emp_job_id'] = array('req' => 1, 'type' => 'list', 'array' => $jobs, 'title' => '_emp_job');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();    
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_length_edit_field('contact_name', $data['contact_name'], $empsentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('contact_name', $data['contact_name'], $empsentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_edit_field('contact_email', $data['contact_email'], $empsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_tel', $data['contact_tel'], $empsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_address', $data['contact_address'], $empsentity, $fields, $fields_temp, $check, $checkerror);
            
            check_select_edit_field('emp_job_id', $data['emp_job_id'], $empsentity, $fields2, $fields_temp, $check, $checkerror);
            check_edit_field('emp_notes', $data['emp_notes'], $empsentity, $fields2, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields2, $fields_temp);
            $edit = true;
            if($check) {
                if(!empty($fields)) {
                    $edit = upd_record('contacts', $fields, array('contact_id' => $data['emp_contact_id']));
                    $fields2['emp_contact_id'] = $data['emp_contact_id'];
                }
            }

            if(!$edit){ 
                $check = false; 
                $checkerror[] = T('_edit_error');
            }            

            update_data($fields_temp, $data);

            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps'. "&id=" .$id . "&action=view");
                confirm_edit('emps', $fields2, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($empsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($empsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $empsentity['lockname'];//Optional
    $data = array();


    $records = get_records('jobs', 'job_id', array('job_id','job_name'), array('job_co_id' => $_SESSION['co_id'],'job_lock' => false));
    $jobs = convert_title_list($records, 'job_name');
    $empsentity['tablefields']['emp_job_id'] = array('req' => 1, 'type' => 'list', 'array' => $jobs, 'title' => '_emp_job');
    $empsentity['tablefields']['contact_user_id'] = $empsentity['tablefields']['emp_user_id'];

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            $empsentity['tablename'] = 'contacts';
            check_length_add_field('contact_name', $empsentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('contact_name', $empsentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_add_field('contact_email', $empsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_tel', $empsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_address', $empsentity, $fields, $fields_temp, $check, $checkerror);
            add_default_field('contact_user_id', $empsentity , $fields, $fields_temp);
            add_default_field('contact_co_id', $empsentity , $fields, $fields_temp);
            $empsentity['tablename'] = 'emps';
            check_select_add_field('emp_job_id', $empsentity, $fields2, $fields_temp, $check, $checkerror);
            check_add_field('emp_notes', $empsentity, $fields2, $fields_temp, $check, $checkerror);   
            add_default_field('emp_user_id', $empsentity , $fields2, $fields_temp);
            check_add_lock_field($lock, $fields2, $fields_temp);
            if($check) {
                if(!empty($fields)) {
                    $add = add_record('contacts', $fields);
                }  
            }

            if(isset($add)&& $add){ 
                $empsentity['tablefields']['emp_contact_id']['default'] = $add;
                add_default_field('emp_contact_id', $empsentity , $fields2, $fields_temp);
            } else { 
                $check = false; 
                $checkerror[] = T('_add_error');
            }

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
                confirm_add('emps', $fields2, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($empsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
    print_add_record($empsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'addfrmcontact'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $entity['lockname'];//Optional
    $data = array();

    $records = get_records('contacts', 'contact_id', array('contact_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'contact_lock' => false));
    $contacts = convert_title_list($records, 'contact_name');
    $records = get_records('emps', 'emp_contact_id', array('emp_contact_id'));
    $myemps = convert_title_list($records, 'emp_contact_id');
    foreach ($contacts as $ind => $value) {
        if(isset($myemps[$ind])) unset($contacts[$ind]);
    }
    $entity['tablefields']['emp_contact_id'] = array('req' => 1, 'type' => 'list', 'array' => $contacts, 'title' => '_emp_name');

    $records = get_records('jobs', 'job_id', array('job_id','job_name'), array('job_co_id' => $_SESSION['co_id'],'job_lock' => false));
    $jobs = convert_title_list($records, 'job_name');
    $entity['tablefields']['emp_job_id'] = array('req' => 1, 'type' => 'list', 'array' => $jobs, 'title' => '_emp_job');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('emp_contact_id', $entity, $fields, $fields_temp, $check, $checkerror);
            check_select_add_field('emp_job_id', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('emp_notes', $entity, $fields, $fields_temp, $check, $checkerror); 
            add_default_field('emp_co_id', $entity , $fields, $fields_temp);
            add_default_field('emp_user_id', $entity , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
                confirm_add('emps', $fields, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=add2");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($entity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'emps');
    print_add_record($entity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}