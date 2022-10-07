<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','addfrmcontact','edit','del','lock','unlock');

$suppliersentity = array(
    'tablename' => 'suppliercontact_view',
    'idname' => 'supplier_id',
    'titlename' => 'contact_name',
    'lockname' => 'supplier_lock',
    'pagetitle' => '_supplierslist',
    'editpagetitle' => '_edit_supplier',
    'addpagetitle' => '_add_new_supplier',
    'delpagetitle' => '_del_supplier', 
    'viewpagetitle' => '_view_supplier', 
    'lockpagetitle' => '_lock_supplier',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'supplier_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_supplier_id','placeholder' => '_auto','basicview' => 0,'label' => 1),
        'supplier_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_contact_name','basicview' => 0,'label' => 1),

        'contact_name' => array('req' => 1, 'type' => 'text', 'title' => '_supplier_name','placeholder' => '_supplier_name_ex','link' => 1,'dvlr1' => 5,'dvlr2' => 30),
        'contact_tel' => array('req' => 0, 'type' => 'tel', 'title' => '_supplier_tel','placeholder' => '_tel_ex','dvlr1' => 5,'dvlr2' => 30),        
        'contact_email' => array('req' => 0, 'type' => 'email', 'title' => '_supplier_email','placeholder' => '_email_ex','dvlr1' => 5,'dvlr2' => 30),
        'contact_address' => array('req' => 0, 'type' => 'textarea', 'title' => '_supplier_address','basicview' => 0),
        'contact_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_supplier_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),

        'supplier_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_supplier_notes','basicview' => 0),
        'supplier_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'supplier_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_supplier_timestamp','placeholder' => '_auto'),
        'supplier_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_supplier_lock','basicview' => 0),
            ),
);

$suppliersentity2 = array(
    'tablename' => 'suppliers',
    'idname' => 'supplier_id',
    'titlename' => 'contact_name',
    'lockname' => 'supplier_lock',
    'pagetitle' => '_supplierslist',
    'editpagetitle' => '_edit_supplier',
    'addpagetitle' => '_add_new_supplier',
    'delpagetitle' => '_del_supplier', 
    'viewpagetitle' => '_view_supplier', 
    'lockpagetitle' => '_lock_supplier',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'supplier_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_supplier_id','placeholder' => '_auto','basicview' => 0),
        'supplier_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_supplier_name'),
        
        'supplier_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_supplier_notes','basicview' => 0),
        'supplier_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','basicview' => 0,'default' => $currentuserid),
        'supplier_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_supplier_timestamp','placeholder' => '_auto'),
        'supplier_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_supplier_lock','basicview' => 0),
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

if($page == 'suppliers' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'suppliers' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0) || ($action == 'addfrmcontact' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}
