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

echo 'link = document.getElementById("link-' . $mod . '-' . 'customers' . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }'."\n";
echo '</script>'."\n";

if(isset($customersentity['allowview'])) $allow['view'] = $customersentity['allowview']; else $allow['view'] = False;
if(isset($customersentity['allowedit'])) $allow['edit'] = $customersentity['allowedit']; else $allow['edit'] = False;
if(isset($customersentity['allowadd'])) $allow['add'] = $customersentity['allowadd']; else $allow['add'] = False;
if(isset($customersentity['allowdel'])) $allow['del'] = $customersentity['allowdel']; else $allow['del'] = False;
if(isset($customersentity['allowlock'])) $allow['lock'] = $customersentity['allowlock']; else $allow['lock'] = False;

if($action == 'no') {
    if(!$allow['view']) {    
        header("Location:index.php");die();
    }
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    $conditions = array('contact_co_id' => $_SESSION['co_id']);
    if(isset($customersentity['tablefields'])) $tablefields = array_keys($customersentity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);
    print_open_xpanel_container($customersentity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=add");
        print_lbtn($link, '_addwithcontact', '_add_record', 'success', 'plus',''); 
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=addfrmcontact");
        print_lbtn($link, '_addfrmcontact', '_add_record', 'success', 'plus','');       
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=customers";
    $with_opts = true;
    $denyview =array();
    $denyedit =array();
    $denydel =array();
    $denylock =array();

    print_data_table ($customersentity, $data,$allow,$page_link,$with_opts,$denyview,$denyedit,$denydel,$denylock);
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
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    if(isset($customersentity['tablefields'])) $tablefields = array_keys($customersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($customersentity['tablename'], array($customersentity['lockname'] => $act), array($customersentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
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
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    if(isset($customersentity['tablefields'])) $tablefields = array_keys($customersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    upd_record($customersentity['tablename'], array($customersentity['lockname'] => $act), array($customersentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    if(isset($customersentity['tablefields'])) $tablefields = array_keys($customersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    print_open_xpanel_container($customersentity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$customersentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        print_ln_solid();
    }
    print_data_record($customersentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
    print_goback_btn_gro($link);
    print_close_xpanel_container();
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    $title = $customersentity['titlename'];//Optional
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
            $check = check_record_relation('customers', $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
                confirm_del('customers', array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($customersentity['delpagetitle']);
    
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($customersentity['titlename'],$customersentity['tablefields'][$customersentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = $customersentity['tablename'];// Required
    $key = $customersentity['idname'];//Optional
    $lock = $customersentity['lockname'];//Optional
    if(isset($customersentity['tablefields'])) $tablefields = array_keys($customersentity['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id,'contact_co_id' => $_SESSION['co_id']);
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('saleslines', 'line_id', array('line_id','line_name','line_lock'), array('line_co_id' => $_SESSION['co_id']));
    foreach ($records as $ind => $value) {
        if(($ind <> $data['customer_line_id']) && $value['line_lock']) unset($records[$ind]);
    }
    $saleslines = convert_title_list($records, 'line_name');
    $customersentity['tablefields']['customer_line_id'] = array('req' => 1, 'type' => 'list', 'array' => $saleslines, 'title' => '_customer_line');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();    
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_length_edit_field('contact_name', $data['contact_name'], $customersentity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('contact_name', $data['contact_name'], $customersentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_edit_field('contact_email', $data['contact_email'], $customersentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_tel', $data['contact_tel'], $customersentity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('contact_address', $data['contact_address'], $customersentity, $fields, $fields_temp, $check, $checkerror);
            
            check_select_edit_field('customer_line_id', $data['customer_line_id'], $customersentity, $fields2, $fields_temp, $check, $checkerror);
            check_edit_field('customer_notes', $data['customer_notes'], $customersentity, $fields2, $fields_temp, $check, $checkerror);
            check_edit_lock_field($data[$lock],$lock, $fields2, $fields_temp);
            $edit = true;
            if($check) {
                if(!empty($fields)) {
                    $edit = upd_record('contacts', $fields, array('contact_id' => $data['customer_contact_id']));
                    $fields2['customer_contact_id'] = $data['customer_contact_id'];
                }
            }

            if(!$edit){ 
                $check = false; 
                $checkerror[] = T('_edit_error');
            }            

            update_data($fields_temp, $data);

            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers'. "&id=" .$id . "&action=view");
                confirm_edit('customers', $fields2, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers'. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($customersentity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers'. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($customersentity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $customersentity['lockname'];//Optional
    $data = array();


    $records = get_records('saleslines', 'line_id', array('line_id','line_name'), array('line_co_id' => $_SESSION['co_id'],'line_lock' => false));
    $saleslines = convert_title_list($records, 'line_name');
    $customersentity['tablefields']['customer_line_id'] = array('req' => 1, 'type' => 'list', 'array' => $saleslines, 'title' => '_customer_line');
    $customersentity['tablefields']['contact_user_id'] = $customersentity['tablefields']['customer_user_id'];

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields2 = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            $customersentity['tablename'] = 'contacts';
            check_length_add_field('contact_name', $customersentity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('contact_name', $customersentity, $fields, $fields_temp, $check, $checkerror,array('contact_co_id' => $_SESSION['co_id']));
            check_add_field('contact_email', $customersentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_tel', $customersentity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('contact_address', $customersentity, $fields, $fields_temp, $check, $checkerror);
            add_default_field('contact_user_id', $customersentity , $fields, $fields_temp);
            add_default_field('contact_co_id', $customersentity , $fields, $fields_temp);
            $customersentity['tablename'] = 'customers';
            check_select_add_field('customer_line_id', $customersentity, $fields2, $fields_temp, $check, $checkerror);
            check_add_field('customer_notes', $customersentity, $fields2, $fields_temp, $check, $checkerror);   
            add_default_field('customer_user_id', $customersentity , $fields2, $fields_temp);
            check_add_lock_field($lock, $fields2, $fields_temp);
            if($check) {
                if(!empty($fields)) {
                    $add = add_record('contacts', $fields);
                }  
            }

            if(isset($add)&& $add){ 
                $customersentity['tablefields']['customer_contact_id']['default'] = $add;
                add_default_field('customer_contact_id', $customersentity , $fields2, $fields_temp);
            } else { 
                $check = false; 
                $checkerror[] = T('_add_error');
            }

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
                confirm_add('customers', $fields2, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($customersentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
    print_add_record($customersentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'addfrmcontact'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $customersentity2['lockname'];//Optional
    $data = array();

    $records = get_records('contacts', 'contact_id', array('contact_id','contact_name'), array('contact_co_id' => $_SESSION['co_id'],'contact_lock' => false));
    $contacts = convert_title_list($records, 'contact_name');
    $records = get_records('customercontact_view', 'customer_contact_id', array('customer_contact_id'), array('contact_co_id' => $_SESSION['co_id']));
    $mycustomers = convert_title_list($records, 'customer_contact_id');
    foreach ($contacts as $ind => $value) {
        if(isset($mycustomers[$ind])) unset($contacts[$ind]);
    }
    $customersentity2['tablefields']['customer_contact_id'] = array('req' => 1, 'type' => 'list', 'array' => $contacts, 'title' => '_customer_name');

    $records = get_records('saleslines', 'line_id', array('line_id','line_name'), array('line_co_id' => $_SESSION['co_id'],'line_lock' => false));
    $saleslines = convert_title_list($records, 'line_name');
    $customersentity2['tablefields']['customer_line_id'] = array('req' => 1, 'type' => 'list', 'array' => $saleslines, 'title' => '_customer_line');

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();

    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('customer_contact_id', $customersentity2, $fields, $fields_temp, $check, $checkerror);
            check_select_add_field('customer_line_id', $customersentity2, $fields, $fields_temp, $check, $checkerror);
            check_add_field('customer_notes', $customersentity2, $fields, $fields_temp, $check, $checkerror); 
            add_default_field('customer_co_id', $customersentity2 , $fields, $fields_temp);
            add_default_field('customer_user_id', $customersentity2 , $fields, $fields_temp);
            check_add_lock_field($lock, $fields, $fields_temp);

            update_data($fields_temp, $data);
            
            //if edit correctly save data and redirect to rec view else stay in editing form with passing the post data.
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
                confirm_add('customers', $fields, $link);
            }

        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=add2");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($customersentity2['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers' . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . 'customers');
    print_add_record($customersentity2,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}