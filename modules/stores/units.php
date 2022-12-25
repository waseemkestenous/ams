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

if(isset($unitsentity['allowview'])) $allow['view'] = $unitsentity['allowview']; else $allow['view'] = False;
if(isset($unitsentity['allowedit'])) $allow['edit'] = $unitsentity['allowedit']; else $allow['edit'] = False;
if(isset($unitsentity['allowadd'])) $allow['add'] = $unitsentity['allowadd']; else $allow['add'] = False;
if(isset($unitsentity['allowdel'])) $allow['del'] = $unitsentity['allowdel']; else $allow['del'] = False;
if(isset($unitsentity['allowlock'])) $allow['lock'] = $unitsentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    $conditions = array('unit_co_id' => $_SESSION['co_id']);
    if(isset($unitsentity['tablefields'])) $tablefields = array_keys($unitsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($unitsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=units";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($unitsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    if(isset($unitsentity['tablefields'])) $tablefields = array_keys($unitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'unit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($unitsentity['tablename'], array($unitsentity['lockname'] => $act), array($unitsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
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
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    if(isset($unitsentity['tablefields'])) $tablefields = array_keys($unitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'unit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($unitsentity['tablename'], array($unitsentity['lockname'] => $act), array($unitsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    if(isset($unitsentity['tablefields'])) $tablefields = array_keys($unitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'unit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($unitsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$unitsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($unitsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    $title = $unitsentity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'unit_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation($unitsentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
                confirm_del($unitsentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($unitsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($unitsentity['titlename'],$unitsentity['tablefields'][$unitsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $unitsentity['tablename'];// Required
    $key = $unitsentity['idname'];//Optional
    $lock = $unitsentity['lockname'];//Optional
    if(isset($unitsentity['tablefields'])) $tablefields = array_keys($unitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'unit_co_id' => $_SESSION['co_id']);
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
            check_length_edit_field('unit_name', $data['unit_name'], $unitsentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('unit_name', $data['unit_name'], $unitsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('unit_notes', $data['unit_notes'], $unitsentity, $fields, $fields_temp, $check, $checkerror);
            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units'. "&id=" .$id . "&action=view");
                confirm_edit($unitsentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($unitsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($unitsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $unitsentity['lockname'];//Optional
    $data = array();
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('unit_name', $unitsentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('unit_name', $unitsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('unit_notes', $unitsentity, $fields, $fields_temp, $check, $checkerror); 
            //check co selection.
            add_default_field('unit_co_id', $unitsentity , $fields, $fields_temp);
            //check user selection.
            add_default_field('unit_user_id', $unitsentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
                confirm_add($unitsentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($unitsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'units');
    print_add_record($unitsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}
