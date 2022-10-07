<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','addfrmcontact','edit','del','lock','unlock');

$linesentity = array(
    'tablename' => 'saleslines',
    'idname' => 'line_id',
    'titlename' => 'line_name',
    'lockname' => 'line_lock',
    'pagetitle' => '_lineslist',
    'editpagetitle' => '_edit_line',
    'addpagetitle' => '_add_new_line',
    'delpagetitle' => '_del_line', 
    'viewpagetitle' => '_view_line', 
    'lockpagetitle' => '_lock_line',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'line_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_line_id','placeholder' => '_auto','basicview' => 0),
        'line_name' => array('req' => 1, 'type' => 'text', 'title' => '_line_name','placeholder' => '_line_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),
        'line_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_line_notes','basicview' => 1),
        'line_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_line_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'line_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'line_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_line_timestamp','placeholder' => '_auto'),
        'line_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_line_lock','basicview' => 0),
    ),
);

$customersentity = array(
    'tablename' => 'customercontact_view',
    'idname' => 'customer_id',
    'titlename' => 'contact_name',
    'lockname' => 'customer_lock',
    'pagetitle' => '_customerslist',
    'editpagetitle' => '_edit_customer',
    'addpagetitle' => '_add_new_customer',
    'delpagetitle' => '_del_customer', 
    'viewpagetitle' => '_view_customer', 
    'lockpagetitle' => '_lock_customer',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'customer_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_customer_id','placeholder' => '_auto','basicview' => 0,'label' => 1),
        'customer_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_contact_name','basicview' => 0,'label' => 1),

        'contact_name' => array('req' => 1, 'type' => 'text', 'title' => '_customer_name','placeholder' => '_customer_name_ex','link' => 1,'dvlr1' => 5,'dvlr2' => 30),
        'contact_tel' => array('req' => 0, 'type' => 'tel', 'title' => '_customer_tel','placeholder' => '_tel_ex','dvlr1' => 5,'dvlr2' => 30),        
        'contact_email' => array('req' => 0, 'type' => 'email', 'title' => '_customer_email','placeholder' => '_email_ex','dvlr1' => 5,'dvlr2' => 30),
        'contact_address' => array('req' => 0, 'type' => 'textarea', 'title' => '_customer_address','basicview' => 0),
        'contact_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_customer_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),

        'customer_line_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'line_id','titlename' => 'line_name','entityname' => 'saleslines', 'title' => '_customer_line','basicview' => 1),
        'customer_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_customer_notes','basicview' => 0),
        'customer_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'customer_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_customer_timestamp','placeholder' => '_auto'),
        'customer_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_customer_lock','basicview' => 0),
            ),
);

$customersentity2 = array(
    'tablename' => 'customers',
    'idname' => 'customer_id',
    'titlename' => 'contact_name',
    'lockname' => 'customer_lock',
    'pagetitle' => '_customerslist',
    'editpagetitle' => '_edit_customer',
    'addpagetitle' => '_add_new_customer',
    'delpagetitle' => '_del_customer', 
    'viewpagetitle' => '_view_customer', 
    'lockpagetitle' => '_lock_customer',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'customer_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_customer_id','placeholder' => '_auto','basicview' => 0),
        'customer_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_customer_name'),
        'customer_line_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'line_id','titlename' => 'line_name','entityname' => 'saleslines', 'title' => '_customer_line','basicview' => 1),
        'customer_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_customer_notes','basicview' => 0),
        'customer_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','basicview' => 0,'default' => $currentuserid),
        'customer_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_customer_timestamp','placeholder' => '_auto'),
        'customer_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_customer_lock','basicview' => 0),
            ),
);

$salesrepsentity = array(
    'tablename' => 'salesrepemp_view',
    'idname' => 'salesrep_id',
    'titlename' => 'contact_name',
    'lockname' => 'salesrep_lock',
    'pagetitle' => '_salesrepslist',
    'editpagetitle' => '_edit_salesrep',
    'addpagetitle' => '_add_new_salesrep',
    'delpagetitle' => '_del_salesrep', 
    'viewpagetitle' => '_view_salesrep', 
    'lockpagetitle' => '_lock_salesrep',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'salesrep_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_salesrep_id','placeholder' => '_auto','basicview' => 0,'label' => 1),
        'salesrep_emp_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'emp_id','titlename' => 'contact_name','entityname' => 'empcontact_view', 'title' => '_salesrep_name','basicview' => 1),
        'contact_name' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_salesrep_name','basicview' => 0,'label' => 1),

        'salesrep_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_salesrep_notes','basicview' => 0),
        'salesrep_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'salesrep_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_salesrep_timestamp','placeholder' => '_auto'),
        'salesrep_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_salesrep_lock','basicview' => 0),
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

if($page == 'salesreps' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'salesreps' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'customers' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'customers' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0) || ($action == 'addfrmcontact' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}