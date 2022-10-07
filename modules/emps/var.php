<?php
$req_modules = array('contacts','companies');

$related_tables['emps']['contacts'] = 'emp_contact_id';
$related_tables['emps']['jobs'] = 'emp_job_id';
$related_tables['emps']['users'] = 'emp_user_id';

$related_tables['jobs']['users'] = 'job_user_id';
$related_tables['jobs']['companies'] = 'job_co_id';