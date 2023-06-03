<?php
$locktype = array(0 => '_not_locked', 1 => '_locked',2 => '_not_set');

$actionlist = array('view','no','add','edit','del','lock','unlock','addfrmcontact');

$records = get_records('companyusers_view', 'userco_user_id', array('userco_user_id','user_name'), array('userco_co_id' => $_SESSION['co_id'], 'user_usertype_id' => 4)); 
$userslist = convert_title_list($records, 'user_name'); //var_dump($userslist);

$checkinsentity = array(
    'tablename' => 'checkins',
    'idname' => 'checkin_id',
    'titlename' => 'checkin_timein',
    'lockname' => 'checkin_lock',
    'pagetitle' => '_checkinslist',
    'editpagetitle' => '_edit_checkin',
    'addpagetitle' => '_add_new_checkin',
    'delpagetitle' => '_del_checkin', 
    'viewpagetitle' => '_view_checkin', 
    'lockpagetitle' => '_lock_checkin',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'checkin_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_checkin_id','placeholder' => '_auto','basicview' => 0),
        'checkin_emp_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'emp_id','titlename' => 'contact_name','entityname' => 'empcontact_view', 'title' => '_emp_name','basicview' => 1),
        'checkin_timein' => array('req' => 1, 'type' => 'text', 'title' => 'checkin_timein','default' => date("Y-m-d", $currenttimestamp)),
        'checkin_timeout' => array('req' => 1, 'type' => 'text', 'title' => 'checkin_timeout','default' => date("Y-m-d", $currenttimestamp)),
        'checkin_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_checkin_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'checkin_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_checkin_notes','basicview' => 0),
        'checkin_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid,'basicview' => 0),
        'checkin_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_checkin_timestamp','placeholder' => '_auto','basicview' => 0),
        'checkin_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_checkin_lock','basicview' => 1),
    ),
);

$holidaysentity = array(
    'tablename' => 'holidays',
    'idname' => 'holiday_id',
    'titlename' => 'holiday_name',
    'lockname' => 'holiday_lock',
    'pagetitle' => '_holidayslist',
    'editpagetitle' => '_edit_holiday',
    'addpagetitle' => '_add_new_holiday',
    'delpagetitle' => '_del_holiday', 
    'viewpagetitle' => '_view_holiday', 
    'lockpagetitle' => '_lock_holiday',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'holiday_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_holiday_id','placeholder' => '_auto','basicview' => 0),
        'holiday_name' => array('req' => 1, 'type' => 'text', 'title' => '_holiday_name','placeholder' => '_holiday_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 50),
        'holiday_date' => array('req' => 1, 'type' => 'date', 'title' => '_holiday_date','default' => date("Y-m-d", $currenttimestamp)),
        'holiday_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_holiday_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'holiday_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_holiday_notes','basicview' => 0),
        'holiday_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'holiday_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_holiday_timestamp','placeholder' => '_auto'),
        'holiday_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_holiday_lock','basicview' => 0),
    ),
);

$deptsentity = array(
    'tablename' => 'departments',
    'idname' => 'dept_id',
    'titlename' => 'dept_name',
    'lockname' => 'dept_lock',
    'pagetitle' => '_deptslist',
    'editpagetitle' => '_edit_dept',
    'addpagetitle' => '_add_new_dept',
    'delpagetitle' => '_del_dept', 
    'viewpagetitle' => '_view_dept', 
    'lockpagetitle' => '_lock_dept',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'dept_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_dept_id','placeholder' => '_auto','basicview' => 0),
        'dept_name' => array('req' => 1, 'type' => 'text', 'title' => '_dept_name','placeholder' => '_dept_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),
        
        'dept_manger_user_id' => array('req' => 0, 'type' => 'list', 'array' => $userslist, 'title' => '_dept_manager_user_name'),
        'dept_assistant_manger_user_id' => array('req' => 0, 'type' => 'list', 'array' => $userslist, 'title' => '_dept_assistant_manager_user_name'),

        'dept_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_dept_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'dept_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_dept_notes','basicview' => 0),
        'dept_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'dept_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_dept_timestamp','placeholder' => '_auto'),
        'dept_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_dept_lock','basicview' => 0),
    ),
);

$jobsentity = array(
    'tablename' => 'jobs',
    'idname' => 'job_id',
    'titlename' => 'job_name',
    'lockname' => 'job_lock',
    'pagetitle' => '_jobslist',
    'editpagetitle' => '_edit_job',
    'addpagetitle' => '_add_new_job',
    'delpagetitle' => '_del_job', 
    'viewpagetitle' => '_view_job', 
    'lockpagetitle' => '_lock_job',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
    	'job_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_job_id','placeholder' => '_auto','basicview' => 0),
        'job_name' => array('req' => 1, 'type' => 'text', 'title' => '_job_name','placeholder' => '_job_name_ex','link' => 1,'dvlr1' => 4,'dvlr2' => 30),

        'job_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_job_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'job_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'job_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_job_timestamp','placeholder' => '_auto'),
        'job_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_job_lock','basicview' => 0),
    ),
);

$empsentity = array(
    'tablename' => 'empcontact_view',
    'idname' => 'emp_id',
    'titlename' => 'contact_name',
    'lockname' => 'emp_lock',
    'pagetitle' => '_empslist',
    'editpagetitle' => '_edit_emp',
    'addpagetitle' => '_add_new_emp',
    'delpagetitle' => '_del_emp', 
    'viewpagetitle' => '_view_emp', 
    'lockpagetitle' => '_lock_emp',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'emp_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_emp_id','placeholder' => '_auto','basicview' => 0,'label' => 1),
        'emp_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_contact_name','basicview' => 0,'label' => 1),

        'contact_name' => array('req' => 1, 'type' => 'text', 'title' => '_emp_name','placeholder' => '_emp_name_ex','link' => 1,'dvlr1' => 5,'dvlr2' => 30),
        'contact_tel' => array('req' => 0, 'type' => 'tel', 'title' => '_emp_tel','placeholder' => '_tel_ex','dvlr1' => 5,'dvlr2' => 30,'basicview' => 0),        
        'contact_email' => array('req' => 0, 'type' => 'email', 'title' => '_emp_email','placeholder' => '_email_ex','dvlr1' => 5,'dvlr2' => 30,'basicview' => 0),
        'contact_address' => array('req' => 0, 'type' => 'textarea', 'title' => '_emp_address','basicview' => 0),
        'contact_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_emp_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),

        'emp_dept_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'dept_id','titlename' => 'dept_name','entityname' => 'departments', 'title' => '_emp_dept','basicview' => 1),
        'emp_job_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'job_id','titlename' => 'job_name','entityname' => 'jobs', 'title' => '_emp_job','basicview' => 1),
        'emp_salary' => array('req' => 0, 'type' => 'number', 'title' => '_emp_salary','placeholder' => '_salary_ex','dvlr1' => 0,'dvlr2' => 100000),    
        'emp_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_emp_notes','basicview' => 0),
        'emp_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'emp_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_emp_timestamp','placeholder' => '_auto'),
        'emp_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_emp_lock','basicview' => 0),
            ),
);

$entity = array(
    'tablename' => 'emps',
    'idname' => 'emp_id',
    'titlename' => 'contact_name',
    'lockname' => 'emp_lock',
    'pagetitle' => '_empslist',
    'editpagetitle' => '_edit_emp',
    'addpagetitle' => '_add_new_emp',
    'delpagetitle' => '_del_emp', 
    'viewpagetitle' => '_view_emp', 
    'lockpagetitle' => '_lock_emp',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'emp_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_emp_id','placeholder' => '_auto','basicview' => 0),
        'emp_contact_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'contact_id','titlename' => 'contact_name','entityname' => 'contacts', 'title' => '_emp_name'),
        'emp_dept_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'dept_id','titlename' => 'dept_name','entityname' => 'departments', 'title' => '_emp_dept','basicview' => 1),
        'emp_job_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'job_id','titlename' => 'job_name','entityname' => 'jobs', 'title' => '_emp_job','basicview' => 1),
        'emp_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_emp_notes','basicview' => 0),
        'emp_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','basicview' => 0,'default' => $currentuserid),
        'emp_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_emp_timestamp','placeholder' => '_auto'),
        'emp_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_emp_lock','basicview' => 0),
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

if($page == 'emps' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
	$header_code_end = $header_code_end . $Datatables_headers; 
	$footer_code_end = $footer_code_end . $Datatables_footers; 	
}
if($page == 'emps' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0) || ($action == 'addfrmcontact' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'jobs' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'jobs' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'depts' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'depts' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'holidays' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'holidays' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}
if($page == 'checkins' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'checkins' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}
