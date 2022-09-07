<?php
// close session in db
close_session_by_userid($currentuserid);
if($enable_loging) user_log($session['session_id'],'logout');
session_destroy();
header("Location:?action=login");
die();