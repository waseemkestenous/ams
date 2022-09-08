<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
<?php
if(in_array($mod, $modules)) {
    if(file_exists("modules/" . $mod . "/" . $page . "php")) 
        include "modules/" . $mod . "/" . $page . "php";
    else if(file_exists("modules/" . $mod . "/index.php")) 
        include "modules/" . $mod . "/index.php";    
    else 
        include "home.php";
} else {
    include "home.php";
}
?>

<?php 
if($debug['print_sql']) { 
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>SQL Query List</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: none;">
<?php
echo "List : " . $sqltxt; 
?>
        </div>
    </div>
</div>
<?php        
}
?>

<?php 
if($debug['print_headers']) { 
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Server Headers Data</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: none;">
<?php
foreach ($_SERVER as $header => $value) {
    echo "$header: $value <br />\n";
}
?>
        </div>
    </div>
</div>
<?php        
}
?>
    </div>
</div>
<!-- /page content -->


