<?php
$req_modules = array('companies','users');

$related_tables['categories']['users'] = 'cat_user_id';
$related_tables['categories']['companies'] = 'cat_co_id';

$related_tables['stores']['users'] = 'store_user_id';
$related_tables['stores']['companies'] = 'store_co_id';