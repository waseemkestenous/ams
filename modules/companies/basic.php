<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','edit','del','lock','unlock');

$entity = array(
    'page' => 71,
    'tablename' => 'companies',
    'idname' => 'co_id',
    'titlename' => 'co_name',
    'lockname' => 'co_lock',
    'pagetitle' => '_companieslist',
    'editpagetitle' => '_edit_company',
    'addpagetitle' => '_add_new_company',
    'delpagetitle' => '_del_company', 
    'viewpagetitle' => '_view_company', 
    'lockpagetitle' => '_lock_company',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
'co_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_co_id','placeholder' => '_auto','basicview' => 0),
'co_name' => array('req' => 1, 'type' => 'text', 'title' => '_co_name','placeholder' => '_co_name_ex','link' => 1,'dvlr1' => 5,'dvlr2' => 30),

'co_email' => array('req' => 0, 'type' => 'email', 'title' => '_co_email','placeholder' => '_email_ex','dvlr1' => 5,'dvlr2' => 30),
'co_tel' => array('req' => 0, 'type' => 'tel', 'title' => '_co_tel','placeholder' => '_tel_ex','dvlr1' => 5,'dvlr2' => 30),
'co_address' => array('req' => 0, 'type' => 'textarea', 'title' => '_co_address'),
'co_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_co_notes','basicview' => 0),

'co_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_user_parent','default' => $currentuserid),
'co_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_co_timestamp','placeholder' => '_auto'),
'co_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_co_lock','basicview' => 0),
    ),
);

$subentity = array(
    'tablename' => 'usercompanies',
    'idname' => 'userco_id',
    'titlename' => 'user_name',
    'lockname' => 'userco_lock',
    'pagetitle' => '_usercompanieslist',
    'editpagetitle' => '_edit_usercompany',
    'addpagetitle' => '_add_new_usercompany',
    'delpagetitle' => '_del_usercompany', 
    'viewpagetitle' => '_view_usercompany', 
    'lockpagetitle' => '_lock_usercompany',  
    'allowview' => True,    
    'allowedit' => false,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
'userco_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_userco_id','placeholder' => '_auto','basicview' => 0),
'userco_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_user'),
'userco_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_co','basicview' => 0),
'userco_notes' => array('req' => 0, 'type' => 'text', 'title' => '_notes','basicview' => 1,'dvlr2' => 255),
'userco_reguser_id' => array('req' => 0, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_user_parent','default' => $currentuserid),
'userco_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_co_timestamp','placeholder' => '_auto'),
'userco_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_co_lock','basicview' => 0),
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
    $footer_code_st = $footer_code_st . $validatin_footers;  
}
/*if($page == 'dash' && $action == 'view' && $id <> 0 ){
    $header_code = $header_code . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}*/
if($page == 'userco' && $action == 'add'){
    $header_code = $header_code . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_footers;  
}
if(in_array($user['user_usertype_id'],array(2))) {
    $entity['allowdel'] = false;
    $entity['allowlock'] = false;  
    $entity['allowadd'] = false; 
    $entity['tablefields']['co_lock']['readonly'] = true;   

}
if(in_array($user['user_usertype_id'],array(3,4))) {
    $entity['allowedit'] = false; 
    $entity['allowdel'] = false;
    $entity['allowlock'] = false;  
    $entity['allowadd'] = false; 
}

if(in_array($user['user_usertype_id'],array(3,4))) {
    $subentity['allowview'] = false; 
    $subentity['allowdel'] = false;
    $subentity['allowlock'] = false;  
    $subentity['allowadd'] = false; 
}