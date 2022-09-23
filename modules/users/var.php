<?php
$moduleid = 81;
$modulename ='users';

$req_modules = array();

$related_tables['users']['usertypes'] = 'user_usertype_id';
$related_tables['users']['users'] = 'user_user_id';

$allowed_usertype_id = array(1,2);

