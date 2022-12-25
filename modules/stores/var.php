<?php
$req_modules = array('companies','users');

$related_tables['categories']['users'] = 'cat_user_id';
$related_tables['categories']['companies'] = 'cat_co_id';

$related_tables['stores']['users'] = 'store_user_id';
$related_tables['stores']['companies'] = 'store_co_id';

$related_tables['units']['users'] = 'unit_user_id';
$related_tables['units']['companies'] = 'unit_co_id';

$related_tables['pricetypes']['users'] = 'pricetype_user_id';
$related_tables['pricetypes']['companies'] = 'pricetype_co_id';

$related_tables['items']['users'] = 'item_user_id';
$related_tables['items']['companies'] = 'item_co_id';