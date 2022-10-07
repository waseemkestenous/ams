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

echo 'link = document.getElementById("link-' . $mod . '-' . 'salesreps' . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }'."\n";
echo '</script>'."\n";

if(isset($salesrepsentity['allowview'])) $allow['view'] = $salesrepsentity['allowview']; else $allow['view'] = False;
if(isset($salesrepsentity['allowedit'])) $allow['edit'] = $salesrepsentity['allowedit']; else $allow['edit'] = False;
if(isset($salesrepsentity['allowadd'])) $allow['add'] = $salesrepsentity['allowadd']; else $allow['add'] = False;
if(isset($salesrepsentity['allowdel'])) $allow['del'] = $salesrepsentity['allowdel']; else $allow['del'] = False;
if(isset($salesrepsentity['allowlock'])) $allow['lock'] = $salesrepsentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    $conditions = array('contact_co_id' => $_SESSION['co_id']);
    if(isset($salesrepsentity['tablefields'])) $tablefields = array_keys($salesrepsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($salesrepsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&action=add");
        print_lbtn($link, '_addwithcontact', '_add_record', 'success', 'plus','');     
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=salesreps";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($salesrepsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    if(isset($salesrepsentity['tablefields'])) $tablefields = array_keys($salesrepsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($salesrepsentity['tablename'], array($salesrepsentity['lockname'] => $act), array($salesrepsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
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
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    if(isset($salesrepsentity['tablefields'])) $tablefields = array_keys($salesrepsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($salesrepsentity['tablename'], array($salesrepsentity['lockname'] => $act), array($salesrepsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    if(isset($salesrepsentity['tablefields'])) $tablefields = array_keys($salesrepsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($salesrepsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$salesrepsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($salesrepsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    $title = $salesrepsentity['titlename'];//Optional
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
            $check = check_record_relation('salesreps', $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
                confirm_del('salesreps', array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($salesrepsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($salesrepsentity['titlename'],$salesrepsentity['tablefields'][$salesrepsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $salesrepsentity['tablename'];// Required
    $key = $salesrepsentity['idname'];//Optional
    $lock = $salesrepsentity['lockname'];//Optional
    if(isset($salesrepsentity['tablefields'])) $tablefields = array_keys($salesrepsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $salesrepsentity['tablefields']['salesrep_emp_id']['readonly'] = 1;

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_edit_field('salesrep_notes', $data['salesrep_notes'], $salesrepsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);           

            update_data($fields_temp, $data);

            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps'. "&id=" .$id . "&action=view");
                confirm_edit('salesreps', $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($salesrepsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($salesrepsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $salesrepsentity['lockname'];//Optional
    $data = array();

    $records = get_records('empcontact_view', 'emp_id', array('emp_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'emp_lock' => false));
    $emps = convert_title_list($records, 'contact_name');

    $records = get_records('salesrepemp_view', 'salesrep_emp_id', array('salesrep_emp_id'), array('contact_co_id' => $_SESSION['co_id']));
    $mysalesreps = convert_title_list($records, 'salesrep_emp_id');
    foreach ($emps as $ind => $value) {
        if(isset($mysalesreps[$ind])) unset($emps[$ind]);
    }

    $salesrepsentity['tablefields']['salesrep_emp_id'] = array('req' => 1, 'type' => 'list', 'array' => $emps, 'title' => '_salesrep_name');
    $salesrepsentity['tablefields']['contact_user_id'] = $salesrepsentity['tablefields']['salesrep_user_id'];

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('salesrep_emp_id', $salesrepsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('salesrep_notes', $salesrepsentity, $fields, $fields_temp, $check, $checkerror);   
            add_default_field('salesrep_user_id', $salesrepsentity , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
                confirm_add('salesreps', $fields, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($salesrepsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'salesreps');
    print_add_record($salesrepsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}