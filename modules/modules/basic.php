<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');
$basictype = array(0 => '_not_basic', 1 => '_basic',2 => '_not_set');

$actionlist = array('view','no','add','edit','del','lock','unlock');


$entity = array(
    'tablename' => 'modules',
    'idname' => 'module_id',
    'titlename' => 'module_name',
    'lockname' => 'module_lock',
    'pagetitle' => '_moduleslist',
    'editpagetitle' => '_edit_module',
    'addpagetitle' => '_add_new_module',
    'delpagetitle' => '_del_module', 
    'viewpagetitle' => '_view_module', 
    'lockpagetitle' => '_lock_module',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'module_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_module_id','placeholder' => '_auto','basicview' => 0),
        'module_name' => array('req' => 1, 'type' => 'text', 'title' => '_module_name','unique' => 1,'placeholder' => '_module_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),
        'module_basic' => array('req' => 0, 'type' => 'yesno', 'array' => $basictype,'readonly' => 0, 'title' => '_module_basic','basicview' => 0),
        'module_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_module_lock','basicview' => 0),
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
	$header_code_end = $header_code_end . $Datatables_headers; 
	$footer_code_end = $footer_code_end . $Datatables_footers; 	
}
if($page == 'dash' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($currentuserid <> 1) {
    $entity['allowadd'] = false;
    $entity['allowedit'] = false;   
    $entity['allowdel'] = false;
    $entity['allowlock'] = false;        
}