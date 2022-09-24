<?php
function check_perms(){
	global $user, $mod, $mods;
	if(!in_array($user['user_usertype_id'],$mods[$mod]['allowed_usertype_id'])) {
		header("Location:index.php");die();
	}
}
function build_menu($menux, $menuy,$title, $link = '', $icon ='', $type = 'sub',$perm = 1) {
	global $menu, $user, $allowed_usertype_id;

	if(!in_array($user['user_usertype_id'], $allowed_usertype_id) && $perm){
		return;
	} else {
		if($type == 'item') {
			$menu[$menux]['id'] = $menux;		
			$menu[$menux]['link'] = $link;
			$menu[$menux]['title'] = T($title);
			$menu[$menux]['icon'] = $icon;
		} else if($type == 'gro') {
			$menu[$menux]['id'] = $menux;	
			$menu[$menux]['type'] = 'gro';
			$menu[$menux]['title'] = $title;
			$menu[$menux]['icon'] = $icon;
		} else {
			$menu[$menux]['submenu'][$menuy]['id'] = $menuy;		
			$menu[$menux]['submenu'][$menuy]['link'] = $link;
			$menu[$menux]['submenu'][$menuy]['title'] = $title;
		}
	}
}
/* ============================== Example To call Function ==============================
$tablename = 'users'; //Required
$conditions = array(); //Optional
$condopr = ''; //Optional - VALUES # '', 'AND', 'OR'

$exist = check_record_exist($tablename, $conditions, $condopr);
==========================================================================================*/
function check_record_exist($tablename, $conditions = array(), $condopr = "AND"){
    global $conn;
    
    if(strtoupper($condopr) != "AND") $condopr = "OR";

    $sql = "SELECT count(1) as `exist` FROM `". $tablename . "`";
    
    $conditiontxt ="";
    if(!empty($conditions)) {
	    foreach ($conditions as $key => $value) {
	        if(empty($conditiontxt)) $sql = $sql . " Where ";
	        else $conditiontxt = $conditiontxt . " " . $condopr . " ";
	        $conditiontxt = $conditiontxt . "`" . $key . "` = '" . addslashes($value) . "'";
	    }
	    $sql = $sql . $conditiontxt . ";";
 	}

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if($row['exist'] > 0) $exist = true; else $exist = false; 

    log_sql($sql);
    
    return $exist;
}
/* ============================== Example To call Function ==============================
$tablename = 'users'; //Required
$fields = array('user_id', 'user_name', 'p_id'); //Optional

$record_id = add_record($tablename, $fields);
==========================================================================================*/
function add_record($tablename, $fields){
    global $conn;

    $sql = "INSERT INTO `" . $tablename . "` (";
    $fieldstxt = "";
    $valuestxt = "";

    foreach ($fields as $key => $value) {
        if(!empty($fieldstxt)) $fieldstxt = $fieldstxt . ",";
        $fieldstxt = $fieldstxt . "`" . $key . "`";
        if(!empty($valuestxt)) $valuestxt = $valuestxt . ",";
        $valuestxt = $valuestxt . "'" . addslashes($value) . "'";
    }
    $sql = $sql . $fieldstxt . ") VALUES (". $valuestxt . ");";

    if($result =  $conn->query($sql))
        $record_id = $conn->insert_id; 
    else     
        $record_id = 0;
    
    log_sql($sql);

    return $record_id;  
}
/* ============================== Example To call Function ==============================
$tablename = 'users'; //Required
$fields = array('user_id', 'user_name', 'p_id'); //Optional
$conditions = array(); //Optional

$updated = upd_record($tablename, $fields, $conditions);
==========================================================================================*/
function upd_record($tablename, $fields = array(), $conditions = array()){
    global $conn;

    $sql = "UPDATE `" . $tablename . "` SET ";
    
    $fieldstxt ="";
    foreach ($fields as $key => $value) {
        if(!empty($fieldstxt)) $fieldstxt = $fieldstxt . ",";
        $fieldstxt = $fieldstxt . "`" . $key . "` = '" . addslashes($value) . "'";
    }
    $sql = $sql . $fieldstxt;
	
	$conditiontxt =""; 
	if(!empty($conditions)) {
	    foreach ($conditions as $key => $value) {
	        if(empty($conditiontxt)) $sql = $sql . " Where ";
	        else $conditiontxt = $conditiontxt . " and ";
	        $conditiontxt = $conditiontxt . "`" . $key . "` = '" . addslashes($value) . "'";
	    } 
	    $sql = $sql . $conditiontxt; 
	}

    log_sql($sql);

    if($result =  $conn->query($sql))
        return true;
    else 
        return false;
}
/* ============================== Example To call Function ==============================
$tablename = 'users'; //Required
$conditions = array(); //Optional

$deleted = del_record($tablename, $conditions);
==========================================================================================*/
function del_record($tablename, $conditions = array()){
    global $conn;

    $sql = "Delete From `" . $tablename . "`";
    
    $conditiontxt = "";
    if(!empty($conditions)) {
	    foreach ($conditions as $key => $value) {
	        if(empty($conditiontxt)) $sql = $sql . " Where ";
	        else $conditiontxt = $conditiontxt . " and ";
	        $conditiontxt = $conditiontxt . "`" . $key . "` = '" . addslashes($value) . "'";
	    } 
	    $sql = $sql . $conditiontxt; 
	}

    log_sql($sql);

    if($result =  $conn->query($sql))
        return true;
    else 
        return false;
}
/* ============================== Example To call Function ==============================
$tablename = 'users'; //Required
$key = 'user_id'; //Optional
$tablefields = array('user_id', 'user_name', 'p_id'); //Optional
$conditions = array(); //Optional
$orderfields = array('user_id'); //Optional
$ordertype = ''; //Optional - VALUES # '', 'ASC', 'DESC'

$records = get_records($tablename, $key, $tablefields, $conditions, $orderfields, $ordertype);
==========================================================================================*/
function get_records($tablename, $key = '', $fields = array(), $conditions = array(), $orderfields = array(), $ordertype = '') {
    global $conn;

    $sql = "SELECT ";
    
    $fieldstxt = "";
    foreach ($fields as $value) {
        if(!empty($fieldstxt)) $fieldstxt = $fieldstxt . ",";
        $fieldstxt = $fieldstxt . "`" . $value . "`";
    }
    if(empty($fieldstxt)) $fieldstxt = "*";
    $sql = $sql . $fieldstxt;

    $sql = $sql . " FROM `" . $tablename . "`";    

    $conditiontxt = "";
    if(!empty($conditions)) {
	    foreach ($conditions as $i => $value) {
	        if(empty($conditiontxt)) $sql = $sql . " WHERE "; 
	        if(!empty($conditiontxt)) $conditiontxt = $conditiontxt . " AND ";
	        $conditiontxt = $conditiontxt . "`".$i."` = '". addslashes($value) . "'";
	    }
    	$sql = $sql . $conditiontxt;
	}

    $orderfieldstxt = "";
    if(!empty($orderfields)) {
	    foreach ($orderfields as $value) {
	        if(empty($orderfieldstxt)) $sql = $sql . " ORDER BY "; 
	        if(!empty($orderfieldstxt)) $orderfieldstxt = $orderfieldstxt . " , ";
	        $orderfieldstxt = $orderfieldstxt . "`" . $value . "`";
	    }
		$sql = $sql . $orderfieldstxt; 

		$ordertypetxt = ""; 
		if(!empty($ordertype)) {
			if(in_array(strtoupper($ordertype), array('ASC','DESC'))) 
				$ordertypetxt = ' ' . $ordertype;
			$sql = $sql . $ordertypetxt; 
		} 
	}
      

    $result = $conn->query($sql);
    
    $rows = array();
    
    if (!empty($result)) {
        $index = 0;
        while($row = $result->fetch_assoc()) {
            $index++;
            if(!empty($key)) $index = $row[$key];
            $rows[$index] = $row;
        }
    }

    log_sql($sql);

    return $rows; 
}
function convert_title_list($records, $title) {
	$list = array();
	foreach ($records as $key => $value) {
		$list[$key] = $value[$title];
	}
	return $list;
}
function print_open_xpanel_container($title, $status = true,$divid = 'main') {
	if($status) {
		$dir = 'up'; 
		$style = 'block';
	}else {
		$dir = 'down';
		$style = 'none';
	}
	echo "<div id='" . $divid . "' class='col-md-12 col-sm-12 col-xs-12'> \n";
    echo "<div class='x_panel'> \n";
	echo "<div class='x_title'> \n";
	echo "<h2>". T($title) . "</h2> \n";
	echo "<ul class='nav navbar-right panel_toolbox'> \n";
	echo "<li> \n";
	echo "<a class='collapse-link'><i class='fa fa-chevron-" . $dir . "'></i></a> \n";
	echo "</li> \n";
	echo "</ul> \n";
	echo "<div class='clearfix'></div> \n";
	echo "</div> \n";
	echo "<div class='x_content' style='display: " . $style . ";'> \n";
}
function print_close_xpanel_container() {
    echo "</div> \n";
    echo "</div> \n";
    echo "</div> \n";
}
function print_open_form($action){
	echo "<form id='edit_record' class='form-horizontal form-label-left' action='" . $action. "' method='post' data-parsley-validate> \n";
}
function print_close_form(){
	echo "</form> \n";
}
function print_ln_solid(){
	echo "<div class='ln_solid'></div> \n";
}
function print_save_btn_gro($cancellink = ''){
	echo "<div class='form-group'> \n";
	echo "<div class='col-md-6 col-sm-6 offset-md-3'> \n";
	print_btn('_save', 'submit', 'primary');
	print_btn('_reset', 'reset', 'info');
	if(!empty($cancellink)) print_lbtn($cancellink, '_cancel', '', 'secondary');
	echo "</div> \n";
	echo "</div> \n";
}
function print_delete_btn_gro($cancellink = ''){

	echo "<div class='form-group'> \n";
	echo "<div class='col-md-6 col-sm-6 offset-md-3'> \n";
	print_btn('_confirm_delete', 'submit', 'danger');
	if(!empty($cancellink)) print_lbtn($cancellink, '_cancel', '', 'secondary');
	echo "</div> \n";
	echo "</div> \n";
}
function print_goback_btn_gro($cancellink = ''){

	echo "<div class='form-group'> \n";
	echo "<div class='col-md-6 col-sm-6 offset-md-3'> \n";
	if(!empty($cancellink)) print_lbtn($cancellink, '_cancel', '', 'secondary');
	echo "</div> \n";
	echo "</div> \n";
}
function print_cancel_btn_gro($cancellink, $text = '_cancel', $class = 'secondary'){

	echo "<div class='form-group'> \n";
	echo "<div class='col-md-6 col-sm-6 offset-md-3'> \n";
	print_lbtn($cancellink, $text, '', $class);
	echo "</div> \n";
	echo "</div> \n";
}
function print_data_record($entity,$data) {
	foreach ($entity['tablefields'] as $field => $properties) {
        if(isset($properties['type']) && $properties['type'] == 'fkey') {
            if(!isset($getjoin[$field])) $getjoin[$field] = True;
            if($getjoin[$field]) {

                $tablename =$properties['entityname'];// Required
                $key = $properties['pkey'];//Optional
                $fields = array($properties['pkey'],$properties['titlename']);//Optional
                $conditions = array();//Optional
                $orderfields = array();//Optional
                $ordertype = ''; //Optional - VALUES # '', 'ASC', 'DESC'

                $records = get_records($tablename, $key, $fields, $conditions, $orderfields, $ordertype);
                $list = convert_title_list($records, $properties['titlename']);
                $getjoin[$field] = False;
            }
            if(isset($list[$data[$field]])) 
                $txt = $list[$data[$field]]; 
            else 
                $txt = 'N/A';
        } else if(isset($properties['type']) &&($properties['type'] == 'list' || $properties['type'] == 'yesno')) {
            if(isset($properties['array'][$data[$field]])) 
                $txt = $properties['array'][$data[$field]]; 
            else 
                $txt = 'N/A';
        } else {
            $txt = $data[$field];
        }
        if($properties['type'] != 'password') print_textbox($field, $properties['title'], T($txt));
    }
}
function print_data_table($entity,$data,$allow,$page_link, $with_opts = false, $denyview = null, $denyedit = null, $denydel = null, $denylock = null) {
	if(!isset($denyview))$denyview = array();
	if(!isset($denyedit))$denyedit = array();
	if(!isset($denydel))$denydel = array();
	if(!isset($denylock))$denylock = array();
	echo "<table id=\"datatable-buttons\" class=\"table table-striped table-bordered\" style=\"width:100%\"> \n";
	echo "<thead> \n";
	echo "<tr> \n";
	echo "<th style=\"width: 1%\">#</th> \n";

	foreach ($entity['tablefields'] as $properties) {
	    if(isset($properties['basicview'])) $basicview = $properties['basicview']; else $basicview = true;
	    if($basicview) echo "<th>" . T($properties['title']) . "</th> \n";
	}
	if($with_opts) {
		if($allow['edit'] || $allow['lock'] || $allow['del'] || $allow['view']) 
			echo "<th>#" . T('_option') . "</th> \n";
	}
	echo "</tr> \n";
	echo "</thead> \n";
	echo "<tbody> \n";

	foreach ($data as $id => $value) {
		if($value[$entity['lockname']]) $lock_rec_css = " class='locked'"; else $lock_rec_css = "";
	    echo "<tr" . $lock_rec_css . "> \n";
		if($allow['view']) {
			$txt = "<a href=\"" . $page_link . "&id=" . $id . "&action=view\">" . $id . "</a> \n";
		} else $txt = $id;
	    echo "<td class='data'>" . $txt . "</td> \n"; 
	    foreach ($entity['tablefields'] as $field => $properties) {
	        if(isset($properties['basicview'])) $basicview = $properties['basicview']; else $basicview = 'text';
	        if($basicview) {
	            if(isset($properties['type']) && $properties['type'] == 'fkey') {
	            	if(!isset($getjoin[$field])) $getjoin[$field] = True;
	                if($getjoin[$field]) {

						$tablename =$properties['entityname'];// Required
						$key = $properties['pkey'];//Optional
						$fields = array($properties['pkey'],$properties['titlename']);//Optional
						$conditions = array();//Optional
						$orderfields = array();//Optional
						$ordertype = ''; //Optional - VALUES # '', 'ASC', 'DESC'

						$records = get_records($tablename, $key, $fields, $conditions, $orderfields, $ordertype);
						$list[$field] = convert_title_list($records, $properties['titlename']);//var_dump($list['userco_co_id']);echo "<br>";
	                    $getjoin[$field] = False;
	                }
	                //echo $field. ":" .$list[$field][$value[$field]]."<br>";
	                if(isset($list[$field][$value[$field]])) 
	                	$txt = $list[$field][$value[$field]]; 
	                else 
	                	$txt = 'N/A';
	            } else if(isset($properties['type']) && $properties['type'] == 'list') {
	            	if(isset($properties['array'][$value[$field]])) 
	            		$txt = $properties['array'][$value[$field]]; 
	            	else 
	            		$txt = 'N/A';
	            } else {
	            	$txt = $value[$field];
	            }
	            if(isset($properties['link']) && $properties['link']) {
	            	if($allow['view']) {
	            		$txt = "<a href=\"" . $page_link . "&id=" . $id . "&action=view\">" . $txt . "</a> \n";
	            	}
	            }
	            echo "<td class='data'>" . $txt . "</td> \n";
	        }
	    }
	    if($with_opts) {
		    if($allow['edit'] || $allow['lock'] || $allow['del'] || $allow['view']) {
		        echo "<td class='opts'> \n";
			    if($allow['view'] && !in_array($id, $denyview)) {
			        print_lbtn($page_link . "&id=" . $id . "&action=view", '_view', '_view_record', 'info', 'eye'); 
			    }
		        if($allow['edit'] && !in_array($id, $denyedit)) {
		        	print_lbtn($page_link . "&id=" . $id . "&action=edit", '_edit', '_edit_record', 'primary', 'pencil');  
		        }
		        if($allow['del'] && !in_array($id, $denydel)) {
		        	print_lbtn($page_link . "&id=" . $id . "&action=del", '_delete', '_del_record', 'danger', 'trash-can');
		        }
		        if($allow['lock'] && !in_array($id, $denylock)) {
		            if($value[$entity['lockname']]) {  
		                print_lbtn($page_link . "&id=" . $id . "&action=unlock&rel=1", '_unlock', '_unlock_record', 'success', 'lock-open');  
		            } else {
		                print_lbtn($page_link . "&id=" . $id . "&action=lock&rel=1", '_lock', '_lock_record', 'dark', 'lock');
		            }
		        }
		        echo"</td> \n";
		    }
		}
	    echo"</tr> \n";
	}
	echo"</tbody> \n";
	echo"</table> \n";
}
function print_del_record($key,$title,$data,$form_code,$action,$cancelaction) {
	print_open_form($action);
	print_input_hidden('form_code', $form_code);
	print_text('_delete_confirm_msg','del_msg');
	print_textbox($key, $title, $data[$key]);
	print_text('_delete_note_msg','note_msg');
	print_ln_solid();
	print_delete_btn_gro($cancelaction);
    print_close_form();
}
function print_text($msg, $class = ''){
	echo "<span class='" . $class . "'><strong>".T($msg) . "</strong></span><br>";
}
function print_add_record($entity,$data,$form_code,$action,$cancelaction) {
	print_open_form($action);
	print_input_hidden('form_code', $form_code);
	foreach ($entity['tablefields'] as $field => $properties) {

	    $title = $properties['title'];
	    if(isset($data[$field])) {
	    	$value = $data[$field]; 
	    }else {
	    	if(in_array($properties['type'], array("fkey", "list", "number", "yesno")))
	    		if(isset($properties['default'])) $value = $properties['default']; else $value = 0; 
	    	else 
	    		$value = '';
	    }
	    if(isset($properties['readonly'])) $readonly = $properties['readonly']; else $readonly = 0;
	    if(isset($properties['req'])) $required = $properties['req']; else $required = 0;
	    if(isset($properties['type'])) $type = $properties['type']; else $type = 'text';
	    if(isset($properties['placeholder'])) $placeholder = $properties['placeholder']; else $placeholder = '';

	    if(isset($properties['dvlr1'])) $dvlr1 = $properties['dvlr1']; else $dvlr1 = '';
	    if(isset($properties['dvlr2'])) $dvlr2 = $properties['dvlr2']; else $dvlr2 = '';
	    if(isset($properties['dvw'])) $dvw = $properties['dvw']; else $dvw = '';
	    if(isset($properties['dvmn'])) $dvmn = $properties['dvmn']; else $dvmn = '';
	    if(isset($properties['dvmx'])) $dvmx = $properties['dvmx']; else $dvmx = '';
	    if(isset($properties['dvl'])) $dvl = $properties['dvl']; else $dvl = '';
	    if(isset($properties['class'])) $class = $properties['class']; else $class = '';
	    if(isset($properties['pattern'])) $pattern = $properties['pattern']; else $pattern = '';
	    
	    if(!$readonly) {
		    if(isset($properties['type']) && $properties['type'] == 'fkey') {
				$tablename = $properties['entityname'];// Required
				$key = $properties['pkey'];//Optional
				$fields = array($properties['pkey'],$properties['titlename']);//Optional
		        $records = get_records($tablename, $key, $fields);

				$list = convert_title_list($records, $properties['titlename']);
		        print_select($field,$title,$value,$list,$readonly,$required,$class);
		    } else if(isset($properties['type']) && $properties['type'] == 'list') {
				$list = $properties['array'];
		        print_select($field,$title,$value,$list,$readonly,$required,$class);
		    } else if(isset($properties['type']) && $properties['type'] == 'yesno') {
		    	$list = $properties['array'];
		        print_checkbox($field,$title,$value,$list,$readonly,$required,$class);
		    } else{
		        print_textbox($field,$title,$value,$readonly,$required,$type,$placeholder,$dvlr1,$dvlr2,$dvw,$dvmn,$dvmx,$dvl, $class, $pattern);
			}
		}

    }
	print_ln_solid();
	print_save_btn_gro($cancelaction);
    print_close_form();
}
function print_edit_record($entity,$data,$form_code,$action,$cancelaction) {
	print_open_form($action);
	print_input_hidden('form_code', $form_code);
	foreach ($entity['tablefields'] as $field => $properties) {

	    $title = $properties['title'];
	    $value = $data[$field];
	    if(isset($properties['readonly'])) $readonly = $properties['readonly']; else $readonly = 0;
	    if(isset($properties['req'])) $required = $properties['req']; else $required = 0;
	    if(isset($properties['type'])) $type = $properties['type']; else $type = 'text';
	    if(isset($properties['placeholder'])) $placeholder = $properties['placeholder']; else $placeholder = '';

	    if(isset($properties['dvlr1'])) $dvlr1 = $properties['dvlr1']; else $dvlr1 = '';
	    if(isset($properties['dvlr2'])) $dvlr2 = $properties['dvlr2']; else $dvlr2 = '';
	    if(isset($properties['dvw'])) $dvw = $properties['dvw']; else $dvw = '';
	    if(isset($properties['dvmn'])) $dvmn = $properties['dvmn']; else $dvmn = '';
	    if(isset($properties['dvmx'])) $dvmx = $properties['dvmx']; else $dvmx = '';
	    if(isset($properties['dvl'])) $dvl = $properties['dvl']; else $dvl = '';
	    if(isset($properties['class'])) $class = $properties['class']; else $class = '';
	    if(isset($properties['pattern'])) $pattern = $properties['pattern']; else $pattern = '';
	    if(isset($properties['pkey'])) {
			$tablename = $properties['entityname'];// Required
			$key = $properties['pkey'];//Optional
			$fields = array($properties['pkey'],$properties['titlename']);//Optional

	        $records = get_records($tablename, $key, $fields);
			$list = convert_title_list($records, $properties['titlename']);
	        print_select($field,$title,$value,$list,$readonly,$required,$class);
	    } else if(isset($properties['type']) && $properties['type'] == 'list') {
			$list = $properties['array'];
	        print_select($field,$title,$value,$list,$readonly,$required,$class);
	    } else if(isset($properties['type']) && $properties['type'] == 'yesno') {
	    	$list = $properties['array'];
	        print_checkbox($field,$title,$value,$list,$readonly,$required,$class);
	    } else {
	    	if(isset($properties['type']) && $properties['type'] == 'password') $required = 0;
	        print_textbox($field,$title,$value,$readonly,$required,$type,$placeholder,$dvlr1,$dvlr2,$dvw,$dvmn,$dvmx,$dvl, $class, $pattern);
	    }
    }
	print_ln_solid();
	print_save_btn_gro($cancelaction);
    print_close_form();
}
/* ==========================================================================================
types : text, email, number, date, time, tel, password , textarea
pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}"
$dvlr1 : data-validate-length-range="6" 
$dvlr1,$dvlr2 : data-validate-length-range="5,15"
$dvmn,$dvmx : data-validate-minmax="10,100"
$dvl : data-validate-linked='password'
$dvl : data-validate-linked='email'
$dvw : data-validate-words="2"
========================================================================================== */
function print_textbox($field, $title, $value, $readonly = true, $required = false, $type = 'text',$placeholder = '',  $dvlr1 = 0,$dvlr2 = 0,$dvw = 0,$dvmn = 0,$dvmx = 0,$dvl = '', $class = '', $pattern ='') {

    $txtvalidation = '';
    if($dvw > 0) 
        $txtvalidation = $txtvalidation . ' data-validate-words="' . $dvw . '"';
    if($dvl <> '') 
        $txtvalidation = $txtvalidation . ' data-validate-linked="' . $dvl . '"';         
    if($dvlr2 > 0) 
        if($dvlr1 > 0) 
            $txtvalidation = $txtvalidation . ' data-validate-length-range="' . $dvlr1 . ',' . $dvlr2 . '"';
        else
            $txtvalidation = $txtvalidation . ' data-validate-length-range="0,' . $dvlr2 . '"';
    else  
        if($dvlr1 > 0) 
            $txtvalidation = $txtvalidation . ' data-validate-length-range="' . $dvlr1 . '"';
    if($dvmn > 0 || $dvmx > 0) 
        $txtvalidation = $txtvalidation . ' data-validate-minmax="' . $dvmn . ',' . $dvmx . '"'; 

    if($readonly) 
        $txtreadonly = ' readonly="readonly"'; 
    else 
        $txtreadonly = '';

    if($required) {
        $txtrequired = ' required="required"';
        $class = $class . " required";
        $reqstric = '<span class="required">*</span>';
    } else {
        $txtrequired = '';
        $class = $class . " optional";
        $reqstric = '';
    }
    if($type == 'password') {
    	//$txtpattern ='';
        $txtpattern = ' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}"';
        if(!isset($_POST[$field]) || empty($_POST[$field])) $value ="";
    }
    else
        if($pattern == "") 
            $txtpattern = ''; 
        else $txtpattern = ' pattern="' . $pattern . '"';
    if (in_array($type, array("email", "number", "date", "time", "tel"))) {
        $class = $class . " " . $type;   
    }
    if (in_array($type, array("pkey","text", "email", "number", "tel")))
        if($placeholder == "") 
            $txtplaceholder = '' ;
        else $txtplaceholder = ' placeholder="' . T($placeholder) . '"';
    else
        $txtplaceholder = '';
    
    echo '<div class="field item form-group">' . "\n";
    echo '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="' . $field . '">' . T($title) . $reqstric . '</label>' . "\n";
    echo '<div class="col-md-6 col-sm-6">' . "\n";

    if($type == 'textarea')
        echo '<textarea id="' . $field . '" name="' . $field . '" class="form-control resizable_textarea' . $class . '"' . $txtreadonly . $txtrequired . $txtplaceholder . '>' . $value . '</textarea>' . "\n";
    else
        echo '<input type="' . $type . '" id="' . $field . '" name="' . $field . '" class="form-control' . $class . '" value="' . $value . '"' . $txtreadonly . $txtrequired . $txtplaceholder . $txtvalidation .  $txtpattern . '>' . "\n";
    
    if($type == 'password') 
        echo '<span class="pass_eye" onclick="hideshow()" >
    		<i id="slash" class="fa fa-eye-slash" style="display: none;"></i>
    		<i id="eye" class="fa fa-eye" style="display: block;"></i></span>' . "\n";

    echo '</div>' . "\n";
    echo '</div>' . "\n";
    /*if($type == 'password') {
    	echo '<div class="field item form-group">' . "\n";
		echo '<label class="control-label col-md-3 col-sm-3 col-xs-12">' . T('_confirm') . " " . T($title) . $reqstric . '</label>' . "\n";
		echo '<div class="col-md-6 col-sm-6">' . "\n";
		echo '<input class="form-control" type="' . $type . '" name="' . $field . '2" data-validate-linked="' . $field . '" ' . $txtrequired . ' />' . "\n";
	    echo '</div>' . "\n";
	    echo '</div>' . "\n";
    }*/
}
function print_select($field, $title, $value, $list, $readonly = true, $required = false,$class = ''){
    if($readonly) 
        $txtreadonly = ' disabled="disabled"'; 
    else 
        $txtreadonly = '';

    if($required) {
        $txtrequired = ' required="required"';
        $class = $class . " required";
        $reqstric = '<span class="required">*</span>' . "\n";
    } else {
        $txtrequired = '';
        $class = $class . " optional";
        $reqstric = '';
    }
    echo '<div class="field item form-group">' . "\n";
    echo '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="' . $field . '">' . T($title) . $reqstric . '</label>' . "\n";
    echo '<div class="col-md-6 col-sm-6">' . "\n";
    echo '<select id="' . $field . '" name="' . $field . '" class="select2_group form-control' . $class . '"' . $txtreadonly . $txtrequired . '>' . "\n";

    echo '<option value="0">' . T('_select_opt') . '</option>' . "\n";
    foreach ($list as $id => $title) {
        if($value == $id) $selected = " SELECTED"; else $selected = "";
            echo '<option value="' . $id . '"' . $selected . '>' . T($title). '</option>' . "\n";
    }
    echo '</select>' . "\n";
    echo '</div>' . "\n";
    echo '</div>' . "\n";
}
function print_checkbox($field, $title, $value, $list, $readonly = true, $required = false,$class = ''){
	if($value == 1 )$txtchecked = " checked"; else $txtchecked = "";
    if($readonly) 
        $txtreadonly = ' disabled="disabled"'; 
    else 
        $txtreadonly = '';

    if($required) {
        $txtrequired = ' required="required"';
        $class = $class . " required";
        $reqstric = '<span class="required">*</span>' . "\n";
    } else {
        $txtrequired = '';
        $class = $class . " optional";
        $reqstric = '';
    }    
	echo '<script>' . "\n";
	echo 'function myFunction() {' . "\n";
	echo '// Get the checkbox' . "\n";
	echo 'var checkBox = document.getElementById("' . $field . '");' . "\n";
	echo '// Get the output text' . "\n";
	echo 'var text = document.getElementById("' . $field . 'txt");' . "\n";
	echo '// If the checkbox is checked, display the output text' . "\n";
	echo 'if (checkBox.checked == true){' . "\n";
	echo 'text.innerHTML = "' . T($list[1]) . '";' . "\n";
	echo '} else {' . "\n";
	echo 'text.innerHTML = "' . T($list[0]) . '";' . "\n";
	echo '}' . "\n";
	echo '}' . "\n";
	echo '</script>' . "\n";

	echo '<div class="form-group row">' . "\n";
	echo '<label class="control-label col-md-3 col-sm-3 ">' . T($title) . $reqstric . '</label>' . "\n";
	echo '<div class="col-md-9 col-sm-9 ">' . "\n";
	echo '<div class="">' . "\n";
	echo '<label>' . "\n";
	echo '<input id="' . $field . '" type="checkbox" class="js-switch' . $class . '" ' . $txtchecked . ' name="' . $field . '" ' . $txtreadonly . ' onclick="myFunction()"/>' . "\n";
	echo '<span id="' . $field . 'txt">'. "&nbsp;&nbsp;";
	if($value == 1) echo T($list[1]); else if($value == 0) echo T($list[0]); else echo T($list[2]); 
	echo '</span>' . "\n";
	echo ' </label>' . "\n";
	echo '</div>' . "\n";
	echo '</div>' . "\n";
	echo '</div>' . "\n";
}
function print_input_hidden($field, $value) {
	echo "<input type='hidden' id='".$field."' name='".$field."' value='".$value."'> \n";
}
function print_lbtn($link, $text, $title = '', $class = 'primary', $icon = '', $size = "sm") {
	if(empty($title)) $title = $text;
	echo "<a href=\"" . $link . "\" class=\"btn btn-" . $class . " btn-" . $size . "\" data-toggle=\"tooltip\" title=\"" . T($title) . "\"><i class=\"fa fa-" . $icon . "\"></i> " . T($text) . "</a> \n";
}
function print_btn($text, $type = 'submit', $class = 'info', $title = '', $size = "sm") {
	if(empty($title)) $title = $text;
	echo "<button class='btn btn-" . $class . " btn-" . $size . "' data-toggle='tooltip' type='" . $type . "' title='" . T($title). "'>" . T($text) . "</button> \n";
}
function print_alert($type='success',$msgs = array(),$closebtn = true) {
	if(!empty($msgs)){
		echo '<div class="alert alert-' . $type . ' alert-dismissible " role="alert">';
		if($closebtn) echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		echo "<ul>";
		foreach ($msgs as $value) {
			echo "<li><strong>" . T($value) . "</strong></li>";
		}
		echo "</ul>";
		echo '</div> ';
	}
}  
function GRS($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function create_form_code(){
	global $session;
	if(isset($_POST['formid'])) del_record('forms', array('form_code' => $_POST['form_code']));
	$form_code = GRS(50);
	del_record('forms', array('form_session_id' => $session['session_id']));
	add_record('forms', array('form_code' => $form_code,'form_session_id' => $session['session_id'],'form_query' => $_SERVER['QUERY_STRING']));
	
	return $form_code;
}
function close_expire_forms() {
    global $conn;
    global $session_timeout;
	global $currenttimestamp;

    $date = new DateTime();
    $lastform = date("Y-m-d H:i:s",$currenttimestamp-$session_timeout);

    $sql = "DELETE FROM `forms` WHERE `reg_timestamp` < '" . addslashes($lastform) . "';";

    $conn->query($sql);   

    log_sql($sql);

    return true;
}
function check_record_relation($tablename, $id, $check){
	global $checkerror, $related_tables;
    foreach ($related_tables as $ind => $value) {
        if(isset($value[$tablename])) {
            $exist = check_record_exist($ind, array($value[$tablename] => $id));
            if(isset($exist) && $exist) {
                $check = false; 
                $checkerror[] = T('_record_related_to_table') . ' : ' . $ind;
            }
        }
    }
    return $check;
}
function check_form(){
	$exist = false;
	if(isset($_POST['form_code'])) $exist = check_record_exist('forms', array('form_code' => $_POST['form_code']));

	return $exist;
}
function confirm_edit($tablename, $fields, $conditions, $redirect){
    $edit = true;
    echo '<script>';
    if(!empty($fields)) {
        $edit = upd_record($tablename, $fields, $conditions);
        if($edit) 
            echo 'alert("'.T('_rec_edit_succ_msg').'");';
        else 
            echo 'alert("'.T('_rec_action_error_msg').'");';
    }
    echo 'location.replace("'.$redirect.'");';
    echo '</script>';
}
function confirm_del($tablename, $conditions, $redirect){
    $del = true;
    $del = del_record($tablename, $conditions);
    echo '<script>';
    if($del) 
        echo 'alert("' . T('_rec_del_succ_msg') . '");';
    else 
        echo 'alert("' . T('_rec_action_error_msg') . '");';
    echo 'location.replace("'.$redirect.'");';
    echo '</script>';
}
function confirm_add($tablename, $fields, $redirect){
    $edit = true;
    echo '<script>';
    if(!empty($fields)) {
        $add = add_record($tablename, $fields);
        if($add) 
            echo 'alert("'.T('_rec_add_succ_msg').'");';
        else 
            echo 'alert("'.T('_rec_action_error_msg').'");';
    }
    echo 'location.replace("'.$redirect.'");';
    echo '</script>';
}
function expire_form($redirect){	
    echo '<script>';
    echo 'alert("'.T('_form_expire_msg').'");';
    echo 'location.replace("'.$redirect.'");';
    echo '</script>';
}
function check_add_lock_field($lock, &$fields, &$fields_temp){
    if(isset($_POST[$lock]) && $_POST[$lock]) {
        $_POST[$lock] = 1; 
    } else { 
        $_POST[$lock] = 0;
    } 
    $fields[$lock] = $_POST[$lock];
    $fields_temp[$lock] = $_POST[$lock];  
}
function check_edit_lock_field($value, $lock, &$fields, &$fields_temp){
    if(isset($_POST[$lock])) {
    	$_POST[$lock] = 1; 
    } else {
    	$_POST[$lock] = 0;
    }
    if(isset($_POST[$lock]) && ($_POST[$lock] <> $value)) {
        $fields[$lock] = $_POST[$lock];
        $fields_temp[$lock] = $_POST[$lock];
    }
}
function check_add_field($field, $entity , &$fields, &$fields_temp, &$check, &$checkerror){
    $valln = strlen($_POST[$field]);
    $fields[$field] = $_POST[$field];
    $fields_temp[$field] = $_POST[$field];
    if(isset($entity['tablefields'][$field]['dvlr2']) && ($valln > $entity['tablefields'][$field]['dvlr2'])) {
        $check = false; 
        $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
    }
}
function check_edit_field($field, $value, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && ($_POST[$field] <> $value)) {
        $valln = strlen($_POST[$field]);
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];      
        if(isset($entity['tablefields'][$field]['dvlr2']) && ($valln > $entity['tablefields'][$field]['dvlr2'])) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
        }
    }
}
function check_length_add_field($field, $entity , &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field])) {
        $valln = strlen($_POST[$field]);
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];
        if(!($valln > $entity['tablefields'][$field]['dvlr1'] && $valln < $entity['tablefields'][$field]['dvlr2'])) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
        }
    } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
        $check = false; 
        $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
    }
}
function check_length_edit_field($field, $value, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && ($_POST[$field] <> $value)) {
        $valln = strlen($_POST[$field]);
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];      
        if(!($valln >= $entity['tablefields']['user_name']['dvlr1'] && $valln <= $entity['tablefields']['user_name']['dvlr2'])) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
        }
    }
}
function check_exist_add_field($field, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field])) {
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field]; 
        $exist = check_record_exist($entity['tablename'], array($field => $_POST[$field]));
        if($exist) {
            $check = false; $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_exist_error');
        }
    } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
        $check = false; 
        $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
    }
}
function check_exist_edit_field($field, $value, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && ($_POST[$field] <> $value)) {
	    $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];    
	    $exist = check_record_exist($entity['tablename'], array($field => $_POST[$field]));
        if($exist) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_exist_error');
        }	        
    }
}
function check_length_add_password($field, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field])) {
        $valln = strlen($_POST[$field]);
        $fields[$field] = md5($_POST[$field]);
        $fields_temp[$field] = $_POST[$field];
        if(!($valln > $entity['tablefields'][$field]['dvlr1'] && $valln < $entity['tablefields'][$field]['dvlr2'])) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
        }
    } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
        $check = false; 
        $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
    }
}
function check_length_edit_password($field, $value, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && !empty($_POST[$field]) && (md5($_POST[$field]) <> $value)) {
        $valln = strlen($_POST[$field]);
        $fields[$field] = md5($_POST[$field]);
        $fields_temp[$field] = $_POST[$field];
        if(!($valln > $entity['tablefields'][$field]['dvlr1'] && $valln < $entity['tablefields'][$field]['dvlr2'])) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_length_error');
        }
    }
}
function check_select_add_field($field, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && isset($entity['tablefields'][$field]['array'][$_POST[$field]])) {
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];
        if(!($_POST[$field] > 0)) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_select_error');
        }
    } else if(isset($entity['tablefields'][$field]['req']) && $entity['tablefields'][$field]['req']){ 
        $check = false; 
        $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_required_error');
    }
}
function check_select_edit_field($field, $value, $entity, &$fields, &$fields_temp, &$check, &$checkerror){
    if(isset($_POST[$field]) && ($_POST[$field] <> $value)) {
        $fields[$field] = $_POST[$field];
        $fields_temp[$field] = $_POST[$field];
        if(!($_POST[$field] > 0)) {
            $check = false; 
            $checkerror[] = T($entity['tablefields'][$field]['title']) . " : " . T('_select_error');
        }
    }
}
function add_default_field($field, $entity , &$fields, &$fields_temp){
	if(isset($entity['tablefields'][$field]['default'])) 
		$fields[$field] = $entity['tablefields'][$field]['default'];
}
function update_data($fields_temp, &$data){
    foreach ($fields_temp as $field => $value) {
        $data[$field] = $value;
    }
}