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

if(isset($itemunitsentity['allowview'])) $allow['view'] = $itemunitsentity['allowview']; else $allow['view'] = False;
if(isset($itemunitsentity['allowedit'])) $allow['edit'] = $itemunitsentity['allowedit']; else $allow['edit'] = False;
if(isset($itemunitsentity['allowadd'])) $allow['add'] = $itemunitsentity['allowadd']; else $allow['add'] = False;
if(isset($itemunitsentity['allowdel'])) $allow['del'] = $itemunitsentity['allowdel']; else $allow['del'] = False;
if(isset($itemunitsentity['allowlock'])) $allow['lock'] = $itemunitsentity['allowlock']; else $allow['lock'] = False;

if(isset($itemunitpricesentity['allowview'])) $suballow['view'] = $itemunitpricesentity['allowview']; else $suballow['view'] = False;
if(isset($itemunitpricesentity['allowedit'])) $suballow['edit'] = $itemunitpricesentity['allowedit']; else $suballow['edit'] = False;
if(isset($itemunitpricesentity['allowadd'])) $suballow['add'] = $itemunitpricesentity['allowadd']; else $suballow['add'] = False;
if(isset($itemunitpricesentity['allowdel'])) $suballow['del'] = $itemunitpricesentity['allowdel']; else $suballow['del'] = False;
if(isset($itemunitpricesentity['allowlock'])) $suballow['lock'] = $itemunitpricesentity['allowlock']; else $suballow['lock'] = False;

if($action == 'lock') {
    $act = 1;
    if(!$allow['lock']) {
        header("Location:index.php");die();
    }
    if(isset($_GET['rel'])){
        if($_GET['rel'] == 1) $rel = 1; 
        else $rel = 0;
    }
    $tablename = $itemunitsentity['tablename'];// Required
    $key = $itemunitsentity['idname'];//Optional
    if(isset($itemunitsentity['tablefields'])) $tablefields = array_keys($itemunitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'itemunit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($itemunitsentity['tablename'], array($itemunitsentity['lockname'] => $act), array($itemunitsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $data['itemunit_item_id'] . "&action=view")."#unitslist";
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
    $tablename = $itemunitsentity['tablename'];// Required
    $key = $itemunitsentity['idname'];//Optional
    if(isset($itemunitsentity['tablefields'])) $tablefields = array_keys($itemunitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'itemunit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($itemunitsentity['tablename'], array($itemunitsentity['lockname'] => $act), array($itemunitsentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $data['itemunit_item_id'] . "&action=view")."#unitslist";
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $itemunitsentity['tablename'];// Required
    $key = $itemunitsentity['idname'];//Optional
    if(isset($itemunitsentity['tablefields'])) $tablefields = array_keys($itemunitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'itemunit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($itemunitsentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$itemunitsentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($itemunitsentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $data['itemunit_item_id'] . "&action=view")."#unitslist";
    print_goback_btn_gro($link);
    print_close_xpanel_container();

    //----------------subentity-----------------
    if($suballow['view'] ){
        $tablename = 'itemunitprices_view';// Required
        $key = 'itemunitprice_id';//Optional
        if(isset($itemunitpricesentity['tablefields'])) $tablefields = array_keys($itemunitpricesentity['tablefields']); else $tablefields = Null;
        $conditions = array('itemunitprice_itemunit_id'=> $id); 
        $data = get_records($tablename, $key, $tablefields, $conditions);
        print_open_xpanel_container($itemunitpricesentity['pagetitle'],true,'unitpriceslist');
        $page_link = "mod=" . $mod . "&page=itemunitprices";
        $with_opts = true;
        $denyview =array();
        $denyedit =array();
        $denydel =array();
        $denylock =array();

        if($suballow['add']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=itemunitprices&id=" . $id . "&action=add");
            print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
            print_ln_solid();
        }
        print_data_table ($itemunitpricesentity, $data,$suballow,$page_link, $with_opts,$denyview,$denyedit,$denydel,$denylock);
        print_close_xpanel_container();
    }

}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }

    $tablename = $itemunitsentity['tablename'];// Required
    $key = $itemunitsentity['idname'];//Optional
    $title = $itemunitsentity['titlename'];//Optional
    $tablefields = array($key,$title,'itemunit_item_id');
    $conditions = array($key => $id,'itemunit_co_id' => $_SESSION['co_id']);
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
            $check = check_record_relation('itemunits', $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $data['itemunit_item_id'] . "&action=view")."#unitslist";
                confirm_del('itemunits', array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($itemunitsentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($itemunitsentity['titlename'],$itemunitsentity['tablefields'][$itemunitsentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $itemunitsentity['tablename'];// Required
    $key = $itemunitsentity['idname'];//Optional
    $lock = $itemunitsentity['lockname'];//Optional
    if(isset($itemunitsentity['tablefields'])) $tablefields = array_keys($itemunitsentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'itemunit_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('units', 'unit_id', array('unit_id','unit_name'), array('unit_co_id' => $_SESSION['co_id'],'unit_lock' => false));
    $units = convert_title_list($records, 'unit_name');
    $itemunitsentity['tablefields']['itemunit_unit_id'] = array('req' => 1, 'type' => 'list', 'array' => $units, 'title' => '_item_unit_name');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_edit_field('itemunit_barcode', $data['itemunit_barcode'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('itemunit_barcode', $data['itemunit_barcode'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_edit_field('itemunit_unit_id', $data['itemunit_unit_id'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('itemunit_amount', $data['itemunit_amount'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('itemunit_buyprice', $data['itemunit_buyprice'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('itemunit_endprice', $data['itemunit_endprice'], $itemunitsentity, $fields, $fields_temp, $check, $checkerror);

            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            
            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits'. "&id=" .$id . "&action=view");
                confirm_edit($itemunitsentity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($itemunitsentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($itemunitsentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $itemunitsentity['lockname'];//Optional
    $data = array();

    $records = get_records('units', 'unit_id', array('unit_id','unit_name'), array('unit_co_id' => $_SESSION['co_id'],'unit_lock' => false));
    $units = convert_title_list($records, 'unit_name');
    $itemunitsentity['tablefields']['itemunit_unit_id'] = array('req' => 1, 'type' => 'list', 'array' => $units, 'title' => '_item_unit_name');

    $itemunitsentity['tablefields']['itemunit_item_id']['default'] = $id;

    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length if changed
            check_length_add_field('itemunit_barcode', $itemunitsentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('itemunit_barcode', $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_select_add_field('itemunit_unit_id', $itemunitsentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('itemunit_amount', $itemunitsentity, $fields, $fields_temp, $check, $checkerror); 
            check_add_field('itemunit_buyprice', $itemunitsentity, $fields, $fields_temp, $check, $checkerror); 
            check_add_field('itemunit_endprice', $itemunitsentity, $fields, $fields_temp, $check, $checkerror); 
    
            add_default_field('itemunit_item_id', $itemunitsentity , $fields, $fields_temp);
            add_default_field('itemunit_co_id', $itemunitsentity , $fields, $fields_temp);
            add_default_field('itemunit_user_id', $itemunitsentity , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);

            update_data($fields_temp, $data);

            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view") . "#unitslist";
                confirm_add($itemunitsentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($itemunitsentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'itemunits' . "&id=" . $id . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'items' . "&id=" . $id . "&action=view")."#unitslist";
    print_add_record($itemunitsentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}