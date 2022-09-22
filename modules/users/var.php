<?php
$moduleid = 81;
$modulename ='users';

$req_modules = array();

$related_tables['users']['user_types'] = 'user_type_id';
$related_tables['users']['users'] = 'p_id';

$allowed_usertype_id = array(1,2);

