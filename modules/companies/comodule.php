<?php 
if(!isset($currentuserid)){    
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("link-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }' . "\n";
echo '</script>'."\n";

if(isset($subentity2['allowview'])) $suballow2['view'] = $subentity2['allowview']; else $suballow2['view'] = False;
if(isset($subentity2['allowedit'])) $suballow2['edit'] = $subentity2['allowedit']; else $suballow2['edit'] = False;
if(isset($subentity2['allowadd'])) $suballow2['add'] = $subentity2['allowadd']; else $suballow2['add'] = False;
if(isset($subentity2['allowdel'])) $suballow2['del'] = $subentity2['allowdel']; else $suballow2['del'] = False;
if(isset($subentity2['allowlock'])) $suballow2['lock'] = $subentity2['allowlock']; else $suballow2['lock'] = False;

if($action == 'view'){
    if(!$suballow2['view']){    
        header("Location:index.php");die();
    }
    $tablename = 'enabledmodules_view';// Required
    $key = $subentity2['idname'];//Optional
    if(isset($subentity2['tablefields'])) $tablefields = array_keys($subentity2['tablefields']); else $tablefields = Null;
	$conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");
        die();
    } 
    print_open_xpanel_container($subentity2['viewpagetitle']);
    if($suballow2['edit'] || $suballow2['lock'] || $suballow2['del']) {
        if($suballow2['edit']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=edit");
            print_lbtn($link, T('_edit'), T('_edit_record'), 'primary', 'pencil');  
        }
        if($suballow2['del']) {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=del");
            print_lbtn($link, T('_delete'), T('_del_record'), 'danger', 'trash-can');
        }
    	print_ln_solid();
    }
    print_data_record($subentity2, $data);
    print_ln_solid();
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data[$subentity2['pfkname']] . "&action=view") . "#moduleslist";
    print_goback_btn_gro($link);
    print_close_xpanel_container();

}else if($action == 'del'){
    if(!$suballow2['del']){    
        header("Location:index.php");die();
    }
    $tablename = 'enabledmodules_view';// Required
    $key = $subentity2['idname'];//Optional
    $title = $subentity2['titlename'];//Optional
    $pfk = $subentity2['pfkname'];
    $tablefields = array($key,$title,$pfk);
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];//var_dump($data);
    if(empty($data)) {
        header("Location:index.php");die();
    }
    if(isset($_POST) && !empty($_POST)) {
        $check = true;
        $checkerror =array();
        $exist = check_form();
        if($exist) {
            //check record tables relations
            $check = check_record_relation($subentity2['tablename'], $id, $check);
            if($check) {
                echo $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $data[$pfk] ."&action=view") . "#moduleslist";
                confirm_del($subentity2['tablename'], array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($subentity2['delpagetitle']);
      
    if(!isset($check)){
        $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
        $cancellink = "javascript:history.go(-1)";
        print_del_record($subentity2['titlename'],$subentity2['tablefields'][$subentity2['titlename']]['title'],$data,$form_code,$link,$cancellink);
    }
    else {
        print_alert('danger', $checkerror);
        $cancellink = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=" . $id . "&action=view");
        print_lbtn($cancellink, '_go_back', '', 'info');
    }
    print_close_xpanel_container();
}else if($action == 'edit'){
    if(!$suballow2['edit']){    
        header("Location:index.php");die();
    }
    $tablename = 'enabledmodules_view';// Required
    $key = $subentity2['idname'];//Optional

    if(isset($subentity2['tablefields'])) $tablefields = array_keys($subentity2['tablefields']); else $tablefields = Null;
    $conditions = array($key => $id); 
    $data = get_records($tablename, $key, $tablefields, $conditions);
    $data = $data[$id];
    if(empty($data)) {
        header("Location:index.php");die();
    }

    $records = get_records('enabledmodules_view', 'comodule_module_id', array('comodule_module_id','module_name'), array('comodule_co_id' => $id));
    $mymodules = convert_title_list($records, 'module_name');

    $records = get_records('modules', 'module_id', array('module_id','module_name'), array('module_basic' => 0));
    $allowedmodules = convert_title_list($records, 'module_name');
    
    foreach ($allowedmodules as $ind => $value) {
        if(isset($mymodules[$ind])) unset($allowedmodules[$ind]);
    }

    unset($subentity2['tablefields']['comodule_module_id']);

    $check = true;
    $checkerror = array();
    $fields = array();
    $fields_temp = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            $records = get_records('enabledmodules_view', '', array('comodule_order'), array('comodule_co_id' => $data['comodule_co_id']));
            $mymodulesorder = convert_title_list($records, 'comodule_order');
            
            foreach ($mymodulesorder as $ind => $value) {
                if($value ==  $data['comodule_order']) unset($mymodulesorder[$ind]);
            }
            if(in_array($_POST['comodule_order'],$mymodulesorder )) 
                $check = false; $checkerror[] = T($subentity2['tablefields']['comodule_order']['title']) . " : " . T('_exist_error');
            check_edit_field('comodule_order', $data['comodule_order'], $subentity2, $fields, $fields_temp, $check, $checkerror);
            update_data($fields_temp, $data);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
                confirm_edit($subentity2['tablename'], $fields, array($key => $id), $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=view");
            expire_form($link);
            die();
        }
    }

    $form_code = create_form_code();
    print_open_xpanel_container($subentity2['editpagetitle']);
    print_alert('danger', $checkerror);
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page. "&id=" .$id . "&action=" . $action);
    $cancelaction = "javascript:history.go(-1)";
    print_edit_record($subentity2, $data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();
}else if($action == 'add'){
    if(!$suballow2['add']){    
        header("Location:index.php");die();
    }
    $data = array();
    $records = get_records('enabledmodules_view', 'comodule_module_id', array('comodule_module_id','module_name'), array('comodule_co_id' => $id));
    $mymodules = convert_title_list($records, 'module_name');

    $records = get_records('modules', 'module_id', array('module_id','module_name'), array('module_basic' => 0,'module_lock' => 0));
    $allowedmodules = convert_title_list($records, 'module_name');
    
    foreach ($allowedmodules as $ind => $value) {
        if(isset($mymodules[$ind])) unset($allowedmodules[$ind]);
    }

    $subentity2['tablefields']['comodule_co_id']['default'] = $id;
    $subentity2['tablefields']['comodule_module_id'] = array('req' => 1, 'type' => 'list', 'array' => $allowedmodules, 'title' => '_module_name');
    $check = true;
    $checkerror = array();
    $fields = array();
    if(isset($_POST) && !empty($_POST)) {
        $exist = check_form();
        if($exist) {
            check_select_add_field('comodule_module_id', $subentity2, $fields, $fields_temp, $check, $checkerror);
            $records = get_records('enabledmodules_view', '', array('comodule_order'), array('comodule_co_id' => $id));
            $mymodulesorder = convert_title_list($records, 'comodule_order');
            if(in_array($_POST['comodule_order'],$mymodulesorder )) 
                $check = false; $checkerror[] = T($subentity2['tablefields']['comodule_order']['title']) . " : " . T('_exist_error');
            check_add_field('comodule_order', $subentity2, $fields, $fields_temp, $check, $checkerror);
            
            add_default_field('comodule_co_id', $subentity2 , $fields, $fields_temp);
            update_data($fields_temp, $data);
            if($check) {
                $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $id . "&action=view") . "#moduleslist";
                confirm_add($subentity2['tablename'], $fields, $link);
            }
        } else {
            $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=". $id . "&action=add");
            expire_form($link);
            die();

        }
    }

    $form_code = create_form_code();

    print_open_xpanel_container($subentity2['addpagetitle']);
    print_alert('danger', $checkerror); 
    $link = "index.php?hash=". encrypturl("mod=" . $mod . "&page=" . $page . "&id=" . $id . "&action=" . $action);
    $cancelaction = "index.php?hash=". encrypturl("mod=" . $mod . "&page=dash&id=". $id . "&action=view") . "#moduleslist";
    print_add_record($subentity2,$data,$form_code,$link,$cancelaction);
    print_close_xpanel_container();

}