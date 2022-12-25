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

if(isset($storesentity['allowview'])) $allow['view'] = $storesentity['allowview']; else $allow['view'] = False;
if(isset($storesentity['allowedit'])) $allow['edit'] = $storesentity['allowedit']; else $allow['edit'] = False;
if(isset($storesentity['allowadd'])) $allow['add'] = $storesentity['allowadd']; else $allow['add'] = False;
if(isset($storesentity['allowdel'])) $allow['del'] = $storesentity['allowdel']; else $allow['del'] = False;
if(isset($storesentity['allowlock'])) $allow['lock'] = $storesentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    $conditions = array('store_co_id' => $_SESSION['co_id']);
    if(isset($storesentity['tablefields'])) $tablefields = array_keys($storesentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($storesentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=stores";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($storesentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    if(isset($storesentity['tablefields'])) $tablefields = array_keys($storesentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'store_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($storesentity['tablename'], array($storesentity['lockname'] => $act), array($storesentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
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
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    if(isset($storesentity['tablefields'])) $tablefields = array_keys($storesentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'store_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($storesentity['tablename'], array($storesentity['lockname'] => $act), array($storesentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    if(isset($storesentity['tablefields'])) $tablefields = array_keys($storesentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'store_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($storesentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$storesentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($storesentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    $title = $storesentity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'store_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation($storesentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
                confirm_del($storesentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($storesentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($storesentity['titlename'],$storesentity['tablefields'][$storesentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $storesentity['tablename'];// Required
    $key = $storesentity['idname'];//Optional
    $lock = $storesentity['lockname'];//Optional
    if(isset($storesentity['tablefields'])) $tablefields = array_keys($storesentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'store_co_id' => $_SESSION['co_id']);
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
            check_length_edit_field('store_name', $data['store_name'], $storesentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('store_name', $data['store_name'], $storesentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('store_notes', $data['store_notes'], $storesentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores'. "&id=" .$id . "&action=view");
                confirm_edit($storesentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($storesentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($storesentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $storesentity['lockname'];//Optional
    $data = array();
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('store_name', $storesentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('store_name', $storesentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('store_notes', $storesentity, $fields, $fields_temp, $check, $checkerror); 
            //check co selection.
            add_default_field('store_co_id', $storesentity , $fields, $fields_temp);
            //check user selection.
            add_default_field('store_user_id', $storesentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
                confirm_add($storesentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($storesentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'stores');
    print_add_record($storesentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}