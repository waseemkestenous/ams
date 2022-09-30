<?php 
if(!isset($currentuserid)){    
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("link-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }' . "\n";
echo '</script>'."\n";

if(isset($subentity['allowview'])) $suballow['view'] = $subentity['allowview']; else $suballow['view'] = False;
if(isset($subentity['allowedit'])) $suballow['edit'] = $subentity['allowedit']; else $suballow['edit'] = False;
if(isset($subentity['allowadd'])) $suballow['add'] = $subentity['allowadd']; else $suballow['add'] = False;
if(isset($subentity['allowdel'])) $suballow['del'] = $subentity['allowdel']; else $suballow['del'] = False;
if(isset($subentity['allowlock'])) $suballow['lock'] = $subentity['allowlock']; else $suballow['lock'] = False;

if($action == 'lock') {
    $act = 1;
	if(!$suballow['lock']){    
        header("Location:index.php");die();
    }
	if(isset($_GET['rel'])){
	    if($_GET['rel'] == 1) $rel = 1; 
	    else $rel = 0;
	}
	$tablename = 'companyusers_view';// Required
	$key = $subentity['idname'];//Optional
	if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $conditions = array($key => $id); 
	$data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
	if(empty($data)) {
	    header("Location:index.php");
	    die();
	}
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos) && $user['user_usertype_id'] <> 1){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if($user['user_usertype_id'] <> 1 ) {
        $pid = $data['user_user_id'];
        while($pid == 0) {
            if($pid <> $currentuserid) {
                $pid = get_user_parent($pid);
            } else {
                header("Location:index.php");
                die(); 
            } 
        }
    }
	upd_record($subentity['tablename'], array($subentity['lockname'] => $act), array($subentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view") ."#userslist";
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data['userco_co_id'] ."&action=view") ."#userslist";
        header("Location:" . $link);die();   
    }
} else if($action == 'unlock') {
    $act = 0;
    if(!$suballow['lock']){    
        header("Location:index.php");die();
    }
    if(isset($_GET['rel'])){
        if($_GET['rel'] == 1) $rel = 1; 
        else $rel = 0;
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos) && $user['user_usertype_id'] <> 1){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if($user['user_usertype_id'] <> 1 ) {
        $pid = $data['user_user_id'];
        while($pid == 0) {
            if($pid <> $currentuserid) {
                $pid = get_user_parent($pid);
            } else {
                header("Location:index.php");
                die(); 
            } 
        }
    }  
    upd_record($subentity['tablename'], array($subentity['lockname'] => $act), array($subentity['idname'] => $id));
    if($rel == 0) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view") ."#userslist";
        header("Location:" . $link);die();
    }
    if($rel == 1) {
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data['userco_co_id'] ."&action=view") ."#userslist";
        header("Location:" . $link);die();   
    }
}else if($action == 'view'){
    if(!$suballow['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    if(isset($subentity['tablefields'])) $tablefields = array_keys($subentity['tablefields']); else $tablefields = Null;
    $tablefields[] = 'user_user_id'; 
    $tablefields[] = 'user_lock'; 
	$conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");
        die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos) && $user['user_usertype_id'] <> 1){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        $suballow['lock'] = false;
        $suballow['del'] = false; 
    }
    if(($data['user_user_id'] <> $currentuserid) && ($user['user_usertype_id'] <> 1) ) {
        $suballow['lock'] = false;
        $suballow['del'] = false; 
    }
    if($data['user_lock']) {
        $suballow['lock'] = false;
        $data['userco_lock'] = 1;
    }  
    print_open_xpanel_container($subentity['viewpagetitle']);
    if($suballow['edit'] || $suballow['lock'] || $suballow['del']) {
        if($suballow['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($suballow['lock']) {
            if($data[$subentity['lockname']]) {  
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=unlock");
                print_lbtn($link, T('_unlock'), T('_unlock_record'), 'success', 'lock-open');  
            } else {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=lock");
                print_lbtn($link, T('_lock'), T('_lock_record'), 'dark', 'lock');
            }
        }
        if($suballow['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
    	print_ln_solid();
    }
    print_data_record($subentity, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data[$subentity['pfkname']] . "&action=view") . "#userslist";
    print_goback_btn_gro($link);
    print_close_xpanel_container();

}else if($action == 'del'){
    if(!$suballow['del']){    
        header("Location:index.php");die();
    }
    $tablename = 'companyusers_view';// Required
    $key = $subentity['idname'];//Optional
    $title = $subentity['titlename'];//Optional
    $tablefields = array($key,'userco_user_id','userco_co_id');
    $tablefields[] = 'user_user_id'; 
    $tablefields[] = 'user_name'; 
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];//var_dump($data);
    if(empty($data)) {
        header("Location:index.php");die();
    }
    $records = get_records('usercompanies_view', '', array('co_id'), array('userco_user_id'=> $currentuserid,'co_lock' => 0));
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($data['userco_co_id'],$mycos) && $user['user_usertype_id'] <> 1){
        header("Location:index.php");die();
    }
    if($data['userco_user_id'] == $currentuserid) {
        header("Location:index.php");
        die();
    }
    if($user['user_usertype_id'] <> 1 ) {
        $pid = $data['user_user_id'];
        while($pid == 0) {
            if($pid <> $currentuserid) {
                $pid = get_user_parent($pid);
            } else {
                header("Location:index.php");
                die(); 
            } 
        }
    }
    if(isset($_POST) && !empty($_POST)) {
        $check = true;
        $checkerror =array();
        $exist = check_form();
        if($exist) {
            //check record tables relations
            $check = check_record_relation($subentity['tablename'], $id, $check);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data[$subentity['pfkname']] ."&action=view") . "#userslist";
                confirm_del($subentity['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($subentity['delpagetitle']);
      
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($subentity['titlename'],$subentity['tablefields'][$subentity['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$suballow['add']){    
        header("Location:index.php");die();
    }
    $tablename = 'usercompanies_view';// Required
    $key = '';//Optional
    $fields = array('co_id');//Optional
    $conditions = array('userco_user_id'=> $currentuserid,'co_lock' => 0); 
    $records = get_records($tablename, $key, $fields, $conditions);
    $mycos = convert_title_list($records, 'co_id');
    if(!in_array($id,$mycos) && $user['user_usertype_id'] <> 1){
        header("Location:index.php");die();
    }
    $lock = $subentity['lockname'];//Optional
    $data = array();
    if($user['user_usertype_id'] == 1) {
        $records = get_records('users', 'user_id', array('user_id','user_name','user_usertype_id'), array('user_lock' => 0));
        foreach ($records as $ind => $value) {
            if($value['user_usertype_id'] == 1)unset($records[$ind]);
        }
    } else {
        $records = get_records('users', 'user_id', array('user_id','user_name'), array('user_user_id'=>$currentuserid,'user_lock' => 0));
    }
    $myusers = convert_title_list($records, 'user_name');
    $records = get_records('usercompanies', 'userco_id', array('userco_id','userco_user_id'), array('userco_co_id'=>$id));
    $cousers = convert_title_list($records, 'userco_user_id');
    foreach ($myusers as $ind => $value) {
         if(in_array($ind,$cousers)) unset($myusers[$ind]);
     } 

    $subentity['tablefields']['userco_co_id']['default'] = $id;
    $subentity['tablefields']['userco_user_id'] = array('req' => 1, 'type' => 'list', 'array' => $myusers, 'title' => '_user');
    
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            //check user type selection.
            check_select_add_field('userco_user_id', $subentity, $fields, $fields_temp, $check, $checkerror);
            if(isset($_POST['userco_user_id'])) {
                $exist = check_record_exist($subentity['tablename'], array('userco_user_id' => $_POST['userco_user_id'],'userco_co_id' => $id));
                if($exist) {
                    $check = false; $checkerror[] = T($subentity['tablefields']['userco_user_id']['title']) . " : " . T('_exist_error');
                }
            } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
                $check = false; 
                $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
            }
            check_add_field('userco_notes', $subentity, $fields, $fields_temp, $check, $checkerror);
            //check user parent selection.
            add_default_field('userco_reguser_id', $subentity , $fields, $fields_temp);
            $subentity['tablefields']['userco_co_id']['default'] = $id;
            add_default_field('userco_co_id', $subentity , $fields, $fields_temp);
            //check field lock if changed               
            check_add_lock_field($lock, $fields, $fields_temp);
            update_data($fields_temp, $data);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $id . "&action=view") . "#userslist";
                confirm_add($subentity['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=". $id . "&action=add");
            expire_form($link);
            die();

        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($subentity['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $id . "&action=view") . "#userslist";
    print_add_record($subentity,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();

}