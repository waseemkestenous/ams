<?php
$moduleid = 71;
$modulename ='companies';

$req_modules = array('users');

$related_tables['companies']['users'] = 'co_user_id';
$related_tables['usercompanies']['users'] = 'userco_user_id';
$related_tables['usercompanies']['companies'] = 'userco_co_id';