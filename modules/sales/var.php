<?php
$req_modules = array('companies','stores','contacts');

$related_tables['customers']['contacts'] = 'customer_contact_id';
$related_tables['customers']['lines'] = 'customer_line_id';
$related_tables['customers']['users'] = 'customer_user_id';

$related_tables['salesreps']['emps'] = 'salesrep_emp_id';
$related_tables['salesreps']['users'] = 'salesrep_user_id';

$related_tables['saleslines']['users'] = 'line_user_id';
$related_tables['saleslines']['companies'] = 'line_co_id';