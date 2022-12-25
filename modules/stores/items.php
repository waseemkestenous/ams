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

if(isset($itemsentity['allowview'])) $allow['view'] = $itemsentity['allowview']; else $allow['view'] = False;
if(isset($itemsentity['allowedit'])) $allow['edit'] = $itemsentity['allowedit']; else $allow['edit'] = False;
if(isset($itemsentity['allowadd'])) $allow['add'] = $itemsentity['allowadd']; else $allow['add'] = False;
if(isset($itemsentity['allowdel'])) $allow['del'] = $itemsentity['allowdel']; else $allow['del'] = False;
if(isset($itemsentity['allowlock'])) $allow['lock'] = $itemsentity['allowlock']; else $allow['lock'] = False;

if(isset($itemunitsentity['allowview'])) $suballow['view'] = $itemunitsentity['allowview']; else $suballow['view'] = False;
if(isset($itemunitsentity['allowedit'])) $suballow['edit'] = $itemunitsentity['allowedit']; else $suballow['edit'] = False;
if(isset($itemunitsentity['allowadd'])) $suballow['add'] = $itemunitsentity['allowadd']; else $suballow['add'] = False;
if(isset($itemunitsentity['allowdel'])) $suballow['del'] = $itemunitsentity['allowdel']; else $suballow['del'] = False;
if(isset($itemunitsentity['allowlock'])) $suballow['lock'] = $itemunitsentity['allowlock']; else $suballow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    $conditions = array('item_co_id' => $_SESSION['co_id']);
    if(isset($itemsentity['tablefields'])) $tablefields = array_keys($itemsentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($itemsentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=items";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($itemsentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    if(isset($itemsentity['tablefields'])) $tablefields = array_keys($itemsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'item_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($itemsentity['tablename'], array($itemsentity['lockname'] => $act), array($itemsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
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
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    if(isset($itemsentity['tablefields'])) $tablefields = array_keys($itemsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'item_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($itemsentity['tablename'], array($itemsentity['lockname'] => $act), array($itemsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    if(isset($itemsentity['tablefields'])) $tablefields = array_keys($itemsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'item_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($itemsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$itemsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($itemsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
    print_goback_btn_gro($link);
    print_close_xpanel_container();

    //----------------subentity-----------------
    if($suballow['view'] ){
        $tablename = 'itemunits_view';// Required
        $key = 'itemunit_id';//Optional
        if(isset($itemunitsentity['tablefields'])) $tablefields = array_keys($itemunitsentity['tablefields']); else $tablefields = Null;
        $conditions = array('itemunit_item_id'=> $id); 
        $data = get_records($tablename, $key, $tablefields, $conditions);
        print_open_xpanel_container($itemunitsentity['pagetitle'],true,'unitslist');
        $page_link = "mod=" . $mod . "&page=itemunits";
        $with_opts = true;
        $denyview =array();
        $denyedit =array();
        $denydel =array();
        $denylock =array();

        if($suballow['add']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=itemunits&id=" . $id . "&action=add");
            print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
            print_ln_solid();
        }
        print_data_table ($itemunitsentity, $data,$suballow,$page_link, $with_opts,$denyview,$denyedit,$denydel,$denylock);
        print_close_xpanel_container();
    }
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    $title = $itemsentity['titlename'];//Optional
    $tablefields = array($key,$title);
    $conditions = array($key => $id,'item_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation($itemsentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
                confirm_del($itemsentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($itemsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($itemsentity['titlename'],$itemsentity['tablefields'][$itemsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $itemsentity['tablename'];// Required
    $key = $itemsentity['idname'];//Optional
    $lock = $itemsentity['lockname'];//Optional
    if(isset($itemsentity['tablefields'])) $tablefields = array_keys($itemsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'item_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('units', 'unit_id', array('unit_id','unit_name','unit_lock'), array('unit_co_id' => $_SESSION['co_id']));
    foreach ($records as $ind => $value) {
        if(($ind <> $data['item_unit_id']) && $value['unit_lock']) unset($records[$ind]);
    }
    $units = convert_title_list($records, 'unit_name');
    $itemsentity['tablefields']['item_unit_id'] = array('req' => 1, 'type' => 'list', 'array' => $units, 'title' => '_item_unit_name');

    $records = get_records('categories', 'cat_id', array('cat_id','cat_name','cat_lock'), array('cat_co_id' => $_SESSION['co_id']));
    foreach ($records as $ind => $value) {
        if(($ind <> $data['item_cat_id']) && $value['cat_lock']) unset($records[$ind]);
    }
    $cats = convert_title_list($records, 'cat_name');
    $itemsentity['tablefields']['item_cat_id'] = array('req' => 1, 'type' => 'list', 'array' => $cats, 'title' => '_item_cat_name');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_edit_field('item_name', $data['item_name'], $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('item_name', $data['item_name'], $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_edit_field('item_unit_id', $data['item_unit_id'], $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_edit_field('item_cat_id', $data['item_cat_id'], $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('item_req', $data['item_req'], $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('item_notes', $data['item_notes'], $itemsentity, $fields, $fields_temp, $check, $checkerror);

            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items'. "&id=" .$id . "&action=view");
                confirm_edit($itemsentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($itemsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($itemsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $itemsentity['lockname'];//Optional
    $data = array();
    
    $records = get_records('units', 'unit_id', array('unit_id','unit_name'), array('unit_co_id' => $_SESSION['co_id'],'unit_lock' => false));
    $units = convert_title_list($records, 'unit_name');
    $itemsentity['tablefields']['item_unit_id'] = array('req' => 1, 'type' => 'list', 'array' => $units, 'title' => '_item_unit_name');

    $records = get_records('categories', 'cat_id', array('cat_id','cat_name'), array('cat_co_id' => $_SESSION['co_id'],'cat_lock' => false));
    $cats = convert_title_list($records, 'cat_name');
    $itemsentity['tablefields']['item_cat_id'] = array('req' => 1, 'type' => 'list', 'array' => $cats, 'title' => '_item_cat_name');

    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('item_name', $itemsentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('item_name', $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_add_field('item_unit_id', $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_add_field('item_cat_id', $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('item_req', $itemsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('item_notes', $itemsentity, $fields, $fields_temp, $check, $checkerror); 
            //check co selection.
            add_default_field('item_co_id', $itemsentity , $fields, $fields_temp);
            //check user selection.
            add_default_field('item_user_id', $itemsentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
                confirm_add($itemsentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($itemsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items');
    print_add_record($itemsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}