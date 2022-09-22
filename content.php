<?php 
if(!isset($currentuserid)) header("Location:index.php");
echo "<!-- page content -->";
echo "<div class=\"right_col\" role=\"main\">";
echo "<div class=\"\">";

$not_load_error = false;
if(in_array($mod, $modules)) {
    
    foreach ($mods[$mod]['req_modules'] as $value) {
    if(!in_array($value,$modules))
        $not_load_error = $not_load_error . "* " . $value . " is not exist.<br>";
    }
    if(!$not_load_error) {
        // include module action file
        if(file_exists("modules/" . $current_modulename  . "/" . $page . ".php")) 
            include "modules/" . $current_modulename  . "/" . $page . ".php";
        else if(file_exists("modules/" . $current_modulename  . "/index.php")) 
            include "modules/" . $current_modulename  . "/index.php";  
    }  
} else {
    include "home.php";
}

if($not_load_error) { 
    print_open_xpanel_container('Modules Required');
    echo $not_load_error; 
    print_close_xpanel_container();      
}

if($debug['print_sql']) { 
    print_open_xpanel_container('SQL Query List',0);
    echo "List : " . $sqltxt; 
    print_close_xpanel_container();         
}

if($debug['print_headers']) { 
    print_open_xpanel_container('Server Headers Data',0);
    foreach ($_SERVER as $header => $value) {
        echo "$header: $value <br />\n";
    }
    print_close_xpanel_container();         
}

echo " </div>";
echo "</div>";
echo "<!-- /page content -->";


