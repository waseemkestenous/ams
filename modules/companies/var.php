<?php

$related_tables['companies']['users'] = 'co_user_id';
$related_tables['usercompanies']['users'] = 'userco_user_id';
$related_tables['usercompanies']['companies'] = 'userco_co_id';

$footer_code[] = 'modify_home_menu();';  

if(isset($_SESSION['co_id'])) {
    $enabledmodules = get_records('enabledmodules_view', 'module_name',array(),array('comodule_co_id' => $_SESSION['co_id'],'module_lock' => 0)); 
}
//var_dump($enabledmodules);