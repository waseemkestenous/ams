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
    	'store_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_store_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'store_name' => array('req' => 1, 'type' => 'text', 'title' => '_store_name','placeholder' => '_store_name_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30),
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
        'cat_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_cat_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'cat_name' => array('req' => 1, 'type' => 'text', 'title' => '_cat_name','placeholder' => '_cat_name_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30),
        'cat_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_cat_notes','basicview' => 1),
        'cat_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_cat_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'cat_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'cat_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_cat_timestamp','placeholder' => '_auto'),
        'cat_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_cat_lock','basicview' => 0),
    ),
);

$unitsentity = array(
    'tablename' => 'units',
    'idname' => 'unit_id',
    'titlename' => 'unit_name',
    'lockname' => 'unit_lock',
    'pagetitle' => '_unitslist',
    'editpagetitle' => '_edit_unit',
    'addpagetitle' => '_add_new_unit',
    'delpagetitle' => '_del_unit', 
    'viewpagetitle' => '_view_unit', 
    'lockpagetitle' => '_lock_unit',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'unit_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_unit_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'unit_name' => array('req' => 1, 'type' => 'text', 'title' => '_unit_name','placeholder' => '_unit_name_ex','link' => 1,'dvlr1' => 2,'dvlr2' => 30),
        'unit_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_unit_notes','basicview' => 1),
        'unit_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_unit_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'unit_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'unit_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_unit_timestamp','placeholder' => '_auto'),
        'unit_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_unit_lock','basicview' => 0),
    ),
);

$pricetypesentity = array(
    'tablename' => 'pricetypes',
    'idname' => 'pricetype_id',
    'titlename' => 'pricetype_name',
    'lockname' => 'pricetype_lock',
    'pagetitle' => '_pricetypeslist',
    'editpagetitle' => '_edit_pricetype',
    'addpagetitle' => '_add_new_pricetype',
    'delpagetitle' => '_del_pricetype', 
    'viewpagetitle' => '_view_pricetype', 
    'lockpagetitle' => '_lock_pricetype',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'pricetype_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_pricetype_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'pricetype_name' => array('req' => 1, 'type' => 'text', 'title' => '_pricetype_name','placeholder' => '_pricetype_name_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30),
        'pricetype_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_pricetype_notes','basicview' => 1),
        'pricetype_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_pricetype_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'pricetype_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid),
        'pricetype_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_pricetype_timestamp','placeholder' => '_auto'),
        'pricetype_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_pricetype_lock','basicview' => 0),
    ),
);

$itemsentity = array(
    'tablename' => 'items',
    'idname' => 'item_id',
    'titlename' => 'item_name',
    'lockname' => 'item_lock',
    'pagetitle' => '_itemslist',
    'editpagetitle' => '_edit_item',
    'addpagetitle' => '_add_new_item',
    'delpagetitle' => '_del_item', 
    'viewpagetitle' => '_view_item', 
    'lockpagetitle' => '_lock_item',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'item_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_item_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'item_name' => array('req' => 1, 'type' => 'text', 'title' => '_item_name','placeholder' => '_item_name_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30),
        'item_unit_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'unit_id','titlename' => 'unit_name','entityname' => 'units', 'title' => '_item_unit_name'),
        'item_cat_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'cat_id','titlename' => 'cat_name','entityname' => 'categories', 'title' => '_item_cat_name'),
        'item_req' => array('req' => 1, 'type' => 'number', 'title' => '_item_req','dvmn' => 0,'dvmx' => 9999),
        'item_notes' => array('req' => 0, 'type' => 'textarea', 'title' => '_item_notes','basicview' => 0),
        'item_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_item_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'item_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid,'basicview' => 0),
        'item_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_item_timestamp','placeholder' => '_auto','basicview' => 0),
        'item_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_item_lock','basicview' => 0),
    ),
);

$itemunitsentity = array(
    'tablename' => 'itemunits_view',
    'idname' => 'itemunit_id',
    'titlename' => 'unit_name',
    'lockname' => 'itemunit_lock',
    'pagetitle' => '_itemunitslist',
    'editpagetitle' => '_edit_itemunit',
    'addpagetitle' => '_add_new_itemunit',
    'delpagetitle' => '_del_itemunit', 
    'viewpagetitle' => '_view_itemunit', 
    'lockpagetitle' => '_lock_itemunit',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'itemunit_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_itemunit_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'itemunit_barcode' => array('req' => 1, 'type' => 'text', 'title' => '_itemunit_barcode','placeholder' => '_itemunit_barcode_ex','link' => 1,'dvlr1' => 3,'dvlr2' => 30,'link' => 1),
        'itemunit_item_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'item_id','titlename' => 'item_name','entityname' => 'items', 'title' => '_item_name','basicview' => 0),
        'itemunit_unit_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'unit_id','titlename' => 'unit_name','entityname' => 'units', 'title' => '_itemunit_unit_name'),
        'unit_name' => array('title' => '_itemunit_unit_name','basicview' => 0,'readonly' => 1,'label'=>1),

        'itemunit_amount' => array('req' => 1, 'type' => 'number', 'title' => '_itemunit_amount','dvmn' => 0,'dvmx' => 9999),
        'itemunit_buyprice' => array('req' => 1, 'type' => 'number', 'title' => '_itemunit_buyprice','dvmn' => 0,'dvmx' => 999999),
        'itemunit_endprice' => array('req' => 1, 'type' => 'number', 'title' => '_itemunit_endprice','dvmn' => 0,'dvmx' => 999999),


        'itemunit_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_itemunit_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'itemunit_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid,'basicview' => 0,'label'=>1),
        'itemunit_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_itemunit_timestamp','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'itemunit_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_itemunit_lock','basicview' => 0),
    ),
);

$itemunitpricesentity = array(
    'tablename' => 'itemunitprices_view',
    'idname' => 'itemunitprice_id',
    'titlename' => 'pricetype_name',
    'lockname' => 'itemunitprice_lock',
    'pagetitle' => '_itemunitpriceslist',
    'editpagetitle' => '_edit_itemunitprice',
    'addpagetitle' => '_add_new_itemunitprice',
    'delpagetitle' => '_del_itemunitprice', 
    'viewpagetitle' => '_view_itemunitprice', 
    'lockpagetitle' => '_lock_itemunitprice',  
    'allowview' => True,    
    'allowedit' => True,
    'allowadd' => True,
    'allowdel' => True,    
    'allowlock' => True,
    'tablefields' => array(
        'itemunitprice_id' => array('req' => 1, 'type' => 'pkey','readonly' => 1, 'title' => '_itemunitprice_id','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'itemunitprice_itemunit_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'unit_id','titlename' => 'unit_name','entityname' => 'units', 'title' => '_itemunit_unit_name','basicview' => 0),
        'itemunitprice_pricetype_id' => array('req' => 1, 'type' => 'fkey','readonly' => 0, 'pkey' => 'pricetype_id','titlename' => 'pricetype_name','entityname' => 'pricetypes', 'title' => '_itemunitprice_pricetype_name'),
        'pricetype_name' => array('title' => '_itemunitprice_pricetype_name','basicview' => 0,'readonly' => 1,'label'=>1),
        'itemunitprice_sellprice' => array('req' => 1, 'type' => 'number', 'title' => '_itemunitprice_sellprice','dvmn' => 0,'dvmx' => 999999),
        'itemunitprice_co_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'co_id','titlename' => 'co_name','entityname' => 'companies', 'title' => '_itemunitprice_co','basicview' => 0,'default' => $_SESSION['co_id'],'label'=>1),
        'itemunitprice_user_id' => array('req' => 1, 'type' => 'fkey','readonly' => 1, 'pkey' => 'user_id','titlename' => 'user_name','entityname' => 'users', 'title' => '_reg_user','default' => $currentuserid,'basicview' => 0,'label'=>1),
        'itemunitprice_timestamp' => array('req' => 0, 'type' => 'text','readonly' => 1, 'title' => '_itemunitprice_timestamp','placeholder' => '_auto','basicview' => 0,'label'=>1),
        'itemunitprice_lock' => array('req' => 0, 'type' => 'yesno', 'array' => $locktype,'readonly' => 0, 'title' => '_itemunitprice_lock','basicview' => 0),
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

if($page == 'units' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'pricetypes' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'items' && $action == 'no' && $id == 0 && $user['user_usertype_id'] == 1){
    $header_code_end = $header_code_end . $Datatables_headers; 
    $footer_code_end = $footer_code_end . $Datatables_footers;  
}
if($page == 'items' && (($action == 'edit' && $id <> 0) || ($action == 'add' && $id == 0))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}

if($page == 'itemunits' && (($action == 'edit' ) || ($action == 'add'))){
    $header_code_end = $header_code_end . $Switchery_headers; 
    $footer_code_st = $footer_code_st . $validatin_pass_footers;  
    $footer_code_st = $footer_code_st . $validatin_footers;  
}