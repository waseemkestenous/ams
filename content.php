<?php if(!isset($currentuserid)) header("Location:index.php");
echo "<!-- page content -->";
echo "<div class=\"right_col\" role=\"main\"> \n";
echo "<div class=\"\"> \n";

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
    print_open_xpanel_container('Modules Required',false,'error');
    echo $not_load_error; 
    print_close_xpanel_container();      
}

if($debug['print_sql']) { 
    print_open_xpanel_container('SQL Query List',false,'sql');
    echo "<div style='direction: ltr; color:#000; text-align:left;'><b>List : " . $sqltxt . "</b></div> \n"; 
    print_close_xpanel_container();         
}

if($debug['print_headers']) { 
    print_open_xpanel_container('Server Headers Data',false,'headers');
    foreach ($_SERVER as $header => $value) {
        echo "<div style='direction: ltr;color:#000; text-align:left;'><b>";
        echo "$header: $value <br />\n";
        echo "</b></div> \n";
    }
    print_close_xpanel_container();         
}

if($debug['print_vars']) { 
    print_open_xpanel_container('Variables Printing',false,'print');
    if(isset($url)) 
        echo "<div style='direction: ltr;color:#000; text-align:left;'><b>URL Parameters : " . $url . "</b></div> \n";
    if(isset($_SESSION['co_id'])) 
        echo "<div style='direction: ltr;color:#000; text-align:left;'><b>SESSION-co_id : " . $_SESSION['co_id'] . "</b></div> \n";
    echo "<div style='direction: ltr;color:#000; text-align:left;'><b>";
    echo "</b></div> \n";
    print_close_xpanel_container();         
}
echo " </div>";
echo "</div>";
echo "<!-- /page content -->";


