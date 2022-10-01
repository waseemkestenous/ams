<?php 
if(!isset($currentuserid)){    
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("link-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }' . "\n";
echo '</script>'."\n";

if(isset($entity['allowview'])) $allow['view'] = $entity['allowview']; else $allow['view'] = False;
if(isset($entity['allowedit'])) $allow['edit'] = $entity['allowedit']; else $allow['edit'] = False;
if(isset($entity['allowadd'])) $allow['add'] = $entity['allowadd']; else $allow['add'] = False;
if(isset($entity['allowdel'])) $allow['del'] = $entity['allowdel']; else $allow['del'] = False;
if(isset($entity['allowlock'])) $allow['lock'] = $entity['allowlock']; else $allow['lock'] = False;

if(isset($subentity['allowview'])) $suballow['view'] = $subentity['allowview']; else $suballow['view'] = False;
if(isset($subentity['allowedit'])) $suballow['edit'] = $subentity['allowedit']; else $suballow['edit'] = False;
if(isset($subentity['allowadd'])) $suballow['add'] = $subentity['allowadd']; else $suballow['add'] = False;
if(isset($subentity['allowdel'])) $suballow['del'] = $subentity['allowdel']; else $suballow['del'] = False;
if(isset($subentity['allowlock'])) $suballow['lock'] = $subentity['allowlock']; else $suballow['lock'] = False;

if(isset($subentity2['allowview'])) $suballow2['view'] = $subentity2['allowview']; else $suballow2['view'] = False;
if(isset($subentity2['allowedit'])) $suballow2['edit'] = $subentity2['allowedit']; else $suballow2['edit'] = False;
if(isset($subentity2['allowadd'])) $suballow2['add'] = $subentity2['allowadd']; else $suballow2['add'] = False;
if(isset($subentity2['allowdel'])) $suballow2['del'] = $subentity2['allowdel']; else $suballow2['del'] = False;
if(isset($subentity2['allowlock'])) $suballow2['lock'] = $subentity2['allowlock']; else $suballow2['lock'] = False;
if($action == 'space') {
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = 'co_id';//Optional
    if($user['user_usertype_id'] == 1) $conditions = array(); 
    else $conditions = array('userco_user_id'=>$currentuserid, 'userco_lock'=> 0, 'co_lock'=> 0); 
    $tablefields = array('co_id','co_name');
    $data = get_records($tablename, $key, $tablefields, $conditions);
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    $_SESSION["co_id"] = $id; 
    header("Location:index.php");die();
} else 
if($action == 'no') {
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = $entity['idname'];//Optional
    if($user['user_usertype_id'] == 1) $conditions = array(); 
    else $conditions = array('userco_user_id'=>$currentuserid, 'userco_lock'=> 0, 'co_lock'=> 0); 

    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
    $data = get_records($tablename, $key, $tablefields, $conditions);

    print_open_xpanel_container($entity['pagetitle']);
    if($allow['add']) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=add");
        print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
        print_ln_solid();
    }
    $page_link = "mod=" . $mod . "&page=dash";
    print_data_table ($entity, $data,$allow,$page_link, 1);
    print_close_xpanel_container();
} else if($action == 'lock') {
    $act = 1;
	if(!$allow['lock']){    
        header("Location:index.php");die();
    }
	if(isset($_GET['rel'])){
	    if($_GET['rel'] == 1) $rel = 1; 
	    else $rel = 0;
	}
	$tablename = 'usercompanies_view';// Required
	$key = $entity['idname'];//Optional
	if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
	if($user['user_usertype_id'] == 1) $conditions = array($key => $id); 
    else $conditions = array($key => $id,'userco_user_id'=>$currentuserid); 
	$data = get_records($tablename, $key, $tablefields, $conditions);
	$data = $data[$id];
	if(empty($data)) {
	    header("Location:index.php");
	    die();
	}

	upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
        header("Location:" . $link);die();   
    }
} else if($action == 'unlock') {
    $act = 0;
	if(!$allow['lock']){    
        header("Location:index.php");die();
    }
	if(isset($_GET['rel'])){
	    if($_GET['rel'] == 1) $rel = 1; 
	    else $rel = 0;
	}
	$tablename = 'usercompanies_view';// Required
	$key = $entity['idname'];//Optional
	if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
	if($user['user_usertype_id'] == 1) $conditions = array($key => $id); 
    else $conditions = array($key => $id,'userco_user_id'=>$currentuserid); 
	$data = get_records($tablename, $key, $tablefields, $conditions);
	$data = $data[$id];
	if(empty($data)) {
	    header("Location:index.php");
	    die();
	}

	upd_record($entity['tablename'], array($entity['lockname'] => $act), array($entity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$allow['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = $entity['idname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
	if($user['user_usertype_id'] == 1) $conditions = array($key => $id); 
    else $conditions = array($key => $id,'userco_user_id'=>$currentuserid); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    if($user['user_usertype_id'] <> 1 && $data['co_lock']){
        header("Location:index.php");die();
    }
    print_open_xpanel_container($entity['viewpagetitle']);
    if($allow['edit'] || $allow['lock'] || $allow['del']) {
        if($allow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($allow['lock']) {
            if($data[$entity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($allow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
        if($user['user_usertype_id'] == 1) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=space");
            print_lbtn($link, T('_select'), T('_select_workspace'), 'warning', 'hat-cowboy'); 
        }
    	print_ln_solid();
    }
    print_data_record($entity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
    print_goback_btn_gro($link);
    print_close_xpanel_container();

    //----------------subentity-----------------
    if($suballow['view'] ){
        $tablename = 'companyusers_view';// Required
        $key = 'userco_id';//Optional
        if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
        $tablefields[] = 'user_user_id'; 
        $tablefields[] = 'user_lock'; 
    	$conditions = array('userco_co_id'=> $id); 
        $data = get_records($tablename, $key, $tablefields, $conditions);
        print_open_xpanel_container($subentity['pagetitle'],true,'userslist');
        $page_link = "mod=" . $mod . "&page=userco";
        $with_opts = true;
        $denyview =array();
        $denyedit =array();
        $denydel =array();
        $denylock =array();
        foreach ($data as $ind => $value) {
            if($value['userco_user_id'] == $currentuserid) {
                $denydel[] = $ind;
                $denylock[] = $ind;
            }

            if($user['user_usertype_id'] <> 1 ) {
                $pid = $value['user_user_id'];
                while($pid == 0) {
                    if($pid <> $currentuserid) {
                        $pid = get_user_parent($pid);
                    } else {
                        $denydel[] = $ind;
                        $denylock[] = $ind; 
                    } 
                }
            }
            if($value['user_lock']) {
                $denylock[] = $ind;
                $data[$ind]['userco_lock'] = 1;
            }            
        }
        if($suballow['add']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=userco&id=" . $id . "&action=add");
            print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
            print_ln_solid();
        }
        print_data_table ($subentity, $data,$suballow,$page_link, $with_opts,$denyview,$denyedit,$denydel,$denylock);
        print_close_xpanel_container();
    }
    //----------------subentity2-----------------
    if($suballow2['view'] ){
        $tablename = 'enabledmodules_view';// Required
        $key = 'comodule_id';//Optional
        if(isset($subentity2['tablefields'])) $tablefields = array_keys($subentity2['tablefields']); else $tablefields = Null;
        $tablefields[] = 'module_lock'; 
        $conditions = array('comodule_co_id'=> $id); 
        $data = get_records($tablename, $key, $tablefields, $conditions);
        print_open_xpanel_container($subentity2['pagetitle'],true,'moduleslist');
        $page_link = "mod=" . $mod . "&page=comodule";

        foreach ($data as $ind => $value) {
            if($value['module_lock']) {
                $data[$ind]['comodule_lock'] = 1;
            }            
        }
        if($suballow2['add']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=comodule&id=" . $id . "&action=add");
            print_lbtn($link, '_add', '_add_record', 'success', 'plus',''); 
            print_ln_solid();
        }
        print_data_table ($subentity2, $data,$suballow2,$page_link,true);
        print_close_xpanel_container();
    }
}else if($action == 'del'){
    if(!$allow['del']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = $entity['idname'];//Optional
    $title = $entity['titlename'];//Optional
    $tablefields = array($key,$title);
	if($user['user_usertype_id'] == 1) $conditions = array($key => $id); 
    else $conditions = array($key => $id,'userco_user_id'=>$currentuserid); 
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
            $check = check_record_relation($entity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
                confirm_del($entity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['delpagetitle']);
       
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($entity['titlename'],$entity['tablefields'][$entity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$allow['edit']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = $entity['idname'];//Optional
    $lock = $entity['lockname'];//Optional
    if(isset($entity['tablefields'])) $tablefields = array_keys($entity['tablefields']); else $tablefields = Null;
	if($user['user_usertype_id'] == 1) $conditions = array($key => $id); 
    else $conditions = array($key => $id,'userco_user_id'=>$currentuserid); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    if($user['user_usertype_id'] <> 1 && $data['co_lock']){
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
            check_length_edit_field('co_name', $data['co_name'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_exist_edit_field('co_name', $data['co_name'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('co_email', $data['co_email'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('co_tel', $data['co_tel'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('co_address', $data['co_address'], $entity, $fields, $fields_temp, $check, $checkerror);
            check_edit_field('co_notes', $data['co_notes'], $entity, $fields, $fields_temp, $check, $checkerror);            

            //check field lock if changed
            check_edit_lock_field($data[$lock],$lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
                confirm_edit($entity['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($entity['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($entity, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$allow['add']){    
        header("Location:index.php");die();
    }
    $lock = $entity['lockname'];//Optional
    $data = array();
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check name length
            check_length_add_field('co_name', $entity , $fields, $fields_temp, $check, $checkerror);
            check_exist_add_field('co_name', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('co_email', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('co_tel', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('co_address', $entity, $fields, $fields_temp, $check, $checkerror);
            check_add_field('co_notes', $entity, $fields, $fields_temp, $check, $checkerror);

            //check user parent selection.
            add_default_field('co_user_id', $entity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
                confirm_add($entity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=add");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($entity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page);
    print_add_record($entity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}