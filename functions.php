<?php
function get_user_by_id($userid) {
    global $conn;

    $sql = "SELECT * FROM `users` Where `user_id` = " . $userid . ";";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    log_sql($sql);

    return $row;
}

function build_menu($menux, $menuy,$title, $link = '', $icon ='', $type = 'sub') {
	global $menu;
	if($type == 'item') {
		$menu[$menux]['id'] = $menux;		
		$menu[$menux]['link'] = $link;
		$menu[$menux]['title'] = $title;
		$menu[$menux]['icon'] = $icon;
	} else if($type == 'gro') {
		$menu[$menux]['id'] = $menux;	
		$menu[$menux]['type'] = 'gro';
		$menu[$menux]['title'] = $title;
		$menu[$menux]['icon'] = $icon;
	} else {
		$menu[$menux]['submenu'][$menuy]['id'] = $menuy;		
		$menu[$menux]['submenu'][$menuy]['link'] = $link;
		$menu[$menux]['submenu'][$menuy]['title'] = $title;
	}
}