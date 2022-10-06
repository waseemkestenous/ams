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

if(isset($jobsentity['allowview'])) $allow['view'] = $jobsentity['allowview']; else $allow['view'] = False;
if(isset($jobsentity['allowedit'])) $allow['edit'] = $jobsentity['allowedit']; else $allow['edit'] = False;
if(isset($jobsentity['allowadd'])) $allow['add'] = $jobsentity['allowadd']; else $allow['add'] = False;
if(isset($jobsentity['allowdel'])) $allow['del'] = $jobsentity['allowdel']; else $allow['del'] = False;
if(isset($jobsentity['allowlock'])) $allow['lock'] = $jobsentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    $conditions = array('job_co_id' => $_SESSION['co_id']);
    if(isset($jobsentity['tablefields'])) $tablefields = array_keys($jobsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($jobsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=jobs";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($jobsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    if(isset($jobsentity['tablefields'])) $tablefields = array_keys($jobsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'job_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($jobsentity['tablename'], array($jobsentity['lockname'] => $act), array($jobsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
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
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    if(isset($jobsentity['tablefields'])) $tablefields = array_keys($jobsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'job_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($jobsentity['tablename'], array($jobsentity['lockname'] => $act), array($jobsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    if(isset($jobsentity['tablefields'])) $tablefields = array_keys($jobsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'job_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($jobsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$jobsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($jobsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    $title = $jobsentity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'job_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation($jobsentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
                confirm_del($jobsentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($jobsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($jobsentity['titlename'],$jobsentity['tablefields'][$jobsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $jobsentity['tablename'];// Required
    $key = $jobsentity['idname'];//Optional
    $lock = $jobsentity['lockname'];//Optional
    if(isset($jobsentity['tablefields'])) $tablefields = array_keys($jobsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'job_co_id' => $_SESSION['co_id']);
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
            check_length_edit_field('job_name', $data['job_name'], $jobsentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('job_name', $data['job_name'], $jobsentity, $fields, $fields_temp, $check, $checkerror);

            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs'. "&id=" .$id . "&action=view");
                confirm_edit($jobsentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($jobsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($jobsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $jobsentity['lockname'];//Optional
    $data = array();
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('job_name', $jobsentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('job_name', $jobsentity, $fields, $fields_temp, $check, $checkerror);

            //check co selection.
            add_default_field('job_co_id', $jobsentity , $fields, $fields_temp);
            //check user selection.
            add_default_field('job_user_id', $jobsentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
                confirm_add($jobsentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($jobsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'jobs');
    print_add_record($jobsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}