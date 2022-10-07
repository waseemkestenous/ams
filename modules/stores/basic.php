<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','edit','del','lock','unlock');


$storesentity = array(
    'tablename' => 'stores',
    'idname' => 'store_id',
    'titlename' => 'store_name',
    'lockname' => 'store_lock',
    'pagetitle' => '_storeslist',
    'editpagetitle' => '_edit_store',
    'addpagetitle' => '_add_new_store',
    'delpagetitle' => '_del_store', 
    'viewpagetitle' => '_view_store', 
    'lockpagetitle' => '_lock_store',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'store_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_store_id','placeholder' => '_auto','basicview' => 0),
        'store_name' => array('req' => 1, 'type' => 'text', 'title' => '_store_name','placeholder' => '_store_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),
        'store_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_store_notes','basicview' => 1),
        'store_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_store_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'store_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'store_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_store_timestamp','placeholder' => '_auto'),
        'store_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_store_lock','basicview' => 0),
    ),
);

$catsentity = array(
    'tablename' => 'categories',
    'idname' => 'cat_id',
    'titlename' => 'cat_name',
    'lockname' => 'cat_lock',
    'pagetitle' => '_catslist',
    'editpagetitle' => '_edit_cat',
    'addpagetitle' => '_add_new_cat',
    'delpagetitle' => '_del_cat', 
    'viewpagetitle' => '_view_cat', 
    'lockpagetitle' => '_lock_cat',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'cat_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_cat_id','placeholder' => '_auto','basicview' => 0),
        'cat_name' => array('req' => 1, 'type' => 'text', 'title' => '_cat_name','placeholder' => '_cat_name_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30),
        'cat_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_cat_notes','basicview' => 1),
        'cat_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_cat_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'cat_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'cat_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_cat_timestamp','placeholder' => '_auto'),
        'cat_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_cat_lock','basicview' => 0),
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

if($page == 'stores' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'stores' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'cats' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'cats' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}