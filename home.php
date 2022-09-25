<?php if(!isset($currentuserid)) header("Location:index.php"); ?>

<?php
echo '<script>'."\n";
if(isset($_SESSION['co_id'])) { 
    if(($user['user_usertype_id'] == 1) || (isset($cocount) && $cocount)) {
        echo 'document.getElementById("link-1").classList.add("current-page");'."\n";  
    } else {
        echo 'document.getElementById("gro-1").classList.add("active");'."\n";
        echo 'document.getElementById("ulgro-1").style = "display:block;"'."\n";
        echo 'document.getElementById("link-Co-' . $_SESSION['co_id'] . '").classList.add("current-page");'."\n";
    }
} else {
    echo 'document.getElementById("link-1").classList.add("current-page");'."\n";  
}
echo '</script>'."\n";
?>

<!-- top tiles -->
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
        <div class="count">2500</div>
        <span class="count_bottom"><i class="blue">4% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
        <div class="count">123.50</div>
        <span class="count_bottom"><i class="blue"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
        <div class="count blue">2,500</div>
        <span class="count_bottom"><i class="blue"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
        <div class="count">4,567</div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
        <div class="count">2,315</div>
        <span class="count_bottom"><i class="blue"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
        <div class="count">7,325</div>
        <span class="count_bottom"><i class="blue"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
</div> 
<!-- /top tiles -->
<?php
foreach ($homecode as $value) {
     eval($value);
 } 
