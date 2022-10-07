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

echo 'link = document.getElementById("link-' . $mod . '-' . 'suppliers' . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }'."\n";
echo '</script>'."\n";

if(isset($suppliersentity['allowview'])) $allow['view'] = $suppliersentity['allowview']; else $allow['view'] = False;
if(isset($suppliersentity['allowedit'])) $allow['edit'] = $suppliersentity['allowedit']; else $allow['edit'] = False;
if(isset($suppliersentity['allowadd'])) $allow['add'] = $suppliersentity['allowadd']; else $allow['add'] = False;
if(isset($suppliersentity['allowdel'])) $allow['del'] = $suppliersentity['allowdel']; else $allow['del'] = False;
if(isset($suppliersentity['allowlock'])) $allow['lock'] = $suppliersentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    $conditions = array('contact_co_id' => $_SESSION['co_id']);
    if(isset($suppliersentity['tablefields'])) $tablefields = array_keys($suppliersentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($suppliersentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=add");
        print_lbtn($link, '_addwithcontact', '_add_record', 'success', 'plus',''); 
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=addfrmcontact");
        print_lbtn($link, '_addfrmcontact', '_add_record', 'success', 'plus','');       
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=suppliers";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($suppliersentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    if(isset($suppliersentity['tablefields'])) $tablefields = array_keys($suppliersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($suppliersentity['tablename'], array($suppliersentity['lockname'] => $act), array($suppliersentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
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
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    if(isset($suppliersentity['tablefields'])) $tablefields = array_keys($suppliersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($suppliersentity['tablename'], array($suppliersentity['lockname'] => $act), array($suppliersentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    if(isset($suppliersentity['tablefields'])) $tablefields = array_keys($suppliersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($suppliersentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$suppliersentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($suppliersentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    $title = $suppliersentity['titlename'];//Optional
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
            $check = check_record_relation('suppliers', $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
                confirm_del('suppliers', array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($suppliersentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($suppliersentity['titlename'],$suppliersentity['tablefields'][$suppliersentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $suppliersentity['tablename'];// Required
    $key = $suppliersentity['idname'];//Optional
    $lock = $suppliersentity['lockname'];//Optional
    if(isset($suppliersentity['tablefields'])) $tablefields = array_keys($suppliersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();    
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_length_edit_field('contact_name', $data['contact_name'], $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('contact_name', $data['contact_name'], $suppliersentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_edit_field('contact_email', $data['contact_email'], $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_tel', $data['contact_tel'], $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_address', $data['contact_address'], $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            
            check_edit_field('supplier_notes', $data['supplier_notes'], $suppliersentity, $fields2, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields2, $fields_temp);
            $edit = true;
            if($check) {
                if(!empty($fields)) {
                    $edit = upd_record('contacts', $fields, array('contact_id' => $data['supplier_contact_id']));
                    $fields2['supplier_contact_id'] = $data['supplier_contact_id'];
                }
            }

            if(!$edit){ 
                $check = false; 
                $checkerror[] = T('_edit_error');
            }            

            update_data($fields_temp, $data);

            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers'. "&id=" .$id . "&action=view");
                confirm_edit('suppliers', $fields2, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($suppliersentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($suppliersentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $suppliersentity['lockname'];//Optional
    $data = array();

    $suppliersentity['tablefields']['contact_user_id'] = $suppliersentity['tablefields']['supplier_user_id'];

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            $suppliersentity['tablename'] = 'contacts';
            check_length_add_field('contact_name', $suppliersentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('contact_name', $suppliersentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_add_field('contact_email', $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_tel', $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_address', $suppliersentity, $fields, $fields_temp, $check, $checkerror);
            add_default_field('contact_user_id', $suppliersentity , $fields, $fields_temp);
            add_default_field('contact_co_id', $suppliersentity , $fields, $fields_temp);
            $suppliersentity['tablename'] = 'suppliers';
            check_add_field('supplier_notes', $suppliersentity, $fields2, $fields_temp, $check, $checkerror);   
            add_default_field('supplier_user_id', $suppliersentity , $fields2, $fields_temp);
            check_add_lock_field($lock, $fields2, $fields_temp);
            if($check) {
                if(!empty($fields)) {
                    $add = add_record('contacts', $fields);
                }  
            }

            if(isset($add)&& $add){ 
                $suppliersentity['tablefields']['supplier_contact_id']['default'] = $add;
                add_default_field('supplier_contact_id', $suppliersentity , $fields2, $fields_temp);
            } else { 
                $check = false; 
                $checkerror[] = T('_add_error');
            }

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
                confirm_add('suppliers', $fields2, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($suppliersentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
    print_add_record($suppliersentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'addfrmcontact'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $suppliersentity2['lockname'];//Optional
    $data = array();

    $records = get_records('contacts', 'contact_id', array('contact_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'contact_lock' => false));
    $contacts = convert_title_list($records, 'contact_name');
    $records = get_records('suppliercontact_view', 'supplier_contact_id', array('supplier_contact_id'), array('contact_co_id' => $_SESSION['co_id']));
    $mysuppliers = convert_title_list($records, 'supplier_contact_id');
    foreach ($contacts as $ind => $value) {
        if(isset($mysuppliers[$ind])) unset($contacts[$ind]);
    }
    $suppliersentity2['tablefields']['supplier_contact_id'] = array('req' => 1, 'type' => 'list', 'array' => $contacts, 'title' => '_supplier_name');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('supplier_contact_id', $suppliersentity2, $fields, $fields_temp, $check, $checkerror);
            check_add_field('supplier_notes', $suppliersentity2, $fields, $fields_temp, $check, $checkerror); 
            add_default_field('supplier_co_id', $suppliersentity2 , $fields, $fields_temp);
            add_default_field('supplier_user_id', $suppliersentity2 , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
                confirm_add('suppliers', $fields, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=add2");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($suppliersentity2['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'suppliers');
    print_add_record($suppliersentity2,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}
