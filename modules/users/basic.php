<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','edit','del','lock','unlock');

if($page == 'dash' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    foreach (array_keys($usertype) as $key) {
        if($user['user_usertype_id'] > $key) 
            if($user['user_usertype_id'] <> 1 ) 
                unset($usertype[$key]); 
    }
}

$entity = array(
    'page' => 81,
    'tablename' => 'users',
    'idname' => 'user_id',
    'titlename' => 'user_username',
    'lockname' => 'user_lock',
    'pagetitle' => '_userslist',
    'editpagetitle' => '_edit_user',
    'addpagetitle' => '_add_new_user',
    'delpagetitle' => '_del_user', 
    'viewpagetitle' => '_view_user', 
    'lockpagetitle' => '_lock_user',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'user_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_user_id','placeholder' => '_auto','basicview' => 0),
        'user_name' => array('req' => 1, 'type' => 'text', 'title' => '_user_name','placeholder' => '_user_name_ex','link' => 1,'dvlr1' => 5,'dvlr2' => 30),
        'user_username' => array('req' => 1, 'type' => 'text', 'title' => '_user_username','unique' => 1,'placeholder' => '_user_username_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),
        'user_password' => array('req' => 1, 'type' => 'password', 'title' => '_user_password','basicview' => 0,'dvlr1' => 8,'dvlr2' => 30),
        'user_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_user_parent','default' => $currentuserid),
        'user_usertype_id' => array('req' => 1, 'type' => 'list', 'array' => $usertype, 'title' => '_user_type'), 
        'user_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_user_timestamp','placeholder' => '_auto'),
        'user_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_user_lock','basicview' => 0),
    ),
);

$Datatables_headers = '
<!-- Datatables -->   
<link href="assets/gentela/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="assets/gentela/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="assets/gentela/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="assets/gentela/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="assets/gentela/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
';
$Datatables_footers = '
<!-- Datatables -->
<script src="assets/gentela/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/gentela/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="assets/gentela/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="assets/gentela/vendors/jszip/dist/jszip.min.js"></script>
<script src="assets/gentela/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/gentela/vendors/pdfmake/build/vfs_fonts.js"></script>
';

$validatin_pass_footers = '
<!-- Javascript functions -->
<script>
    function hideshow(){
        var password = document.getElementById("user_password");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");
        
        if(password.type === "password"){
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        }
        else{
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";
        }

    }
</script>';
$validatin_footers = '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="assets/gentela/vendors/validator/multifield.js"></script>
<script src="assets/gentela/vendors/validator/validator.js"></script>
<!-- Switchery -->
    <script src="assets/gentela/vendors/switchery/dist/switchery.min.js"></script>
<script>
    // initialize a validator instance from the "FormValidator" constructor.
    // A "<form>" element is optionally passed as an argument, but is not a must
    var validator = new FormValidator({
        "events": ["blur", "input", "change"]
    }, document.forms[0]);
    // on form "submit" event
    document.forms[0].onsubmit = function(e) {
        var submit = true,
            validatorResult = validator.checkAll(this);
        console.log(validatorResult);
        return !!validatorResult.valid;
    };
    // on form "reset" event
    document.forms[0].onreset = function(e) {
        validator.reset();
    };
    // stuff related ONLY for this demo page:
    $(".toggleValidationTooltips").change(function() {
        validator.settings.alerts = !this.checked;
        if (this.checked)
            $("form .alert").remove();
    }).prop("checked", false);

</script>';

$Switchery_headers = '
<!-- Switchery -->
<link href="assets/gentela/vendors/switchery/dist/switchery.min.css" rel="stylesheet">';

if($page == 'dash' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
	$header_code = $header_code . $Datatables_headers; 
	$footer_code_end = $footer_code_end . $Datatables_footers; 	
}
if($page == 'dash' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code = $header_code . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($id == 1) {
    $entity['allowdel'] = false;
    $entity['allowlock'] = false;   
    if($currentuserid <> 1) $entity['allowedit'] = false;      
    $entity['tablefields']['user_username']['readonly'] = true;
    $entity['tablefields']['user_usertype_id']['readonly'] = true;  
    $entity['tablefields']['user_lock']['readonly'] = true;       
}
if($id == $currentuserid) {
    $entity['allowdel'] = false;
    $entity['allowlock'] = false;    
    $entity['tablefields']['user_lock']['readonly'] = true;       
}
