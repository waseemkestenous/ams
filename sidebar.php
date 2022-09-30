<?php if(!isset($currentuserid)) header("Location:index.php"); ?>
<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title"><i class="fa fa-chart-line"></i> <span><?php echo $co; ?></span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo $user['user_profile_pic']; ?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span><?php echo T('_welcome'); ?>,</span>
                <h2><?php echo $user['user_name']; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <!--<h3>General</h3>-->
                <ul class="nav side-menu">
<?php 
foreach ($menusort as $value) {
    if(isset($menu[$value])){
        if(isset($menu[$value]['type']) && $menu[$value]['type'] == 'gro') {
            echo '<li id="gro-' . $value . '">'." \n";
                echo '<a>';
                    echo '<i class="fa fa-' . $menu[$value]['icon']  . '"></i>';
                    echo $menu[$value]['title'];
                    echo '<span class="fa fa-chevron-down"></span>';
                echo '</a>'." \n";
                echo '<ul id="ulgro-' . $value . '" class="nav child_menu" style="display: none;">'." \n";
                if(!empty($menu[$value]['submenu']))
                    foreach ($menu[$value]['submenu'] as $subkey => $subvalue) {   
                        echo '<li id="link-' . $subkey . '">'." \n";
                        echo '<a href="' . $subvalue['link']  . '">';
                        echo '<i class="fa"></i>';
                        echo $subvalue['title'];
                        echo '<span class="fa"></span>';
                        echo '</a>'." \n";
                        echo '</li>'." \n";
                    }
                echo '</ul>'." \n";
            echo '</li>'." \n";
        } else {
            echo '<li id="link-' . $value . '">'." \n";
            echo '<a href="' . $menu[$value]['link']  . '">';
            echo '<i class="fa fa-' . $menu[$value]['icon']  . '"></i>';
            echo $menu[$value]['title'];
            echo '</a>';
            echo '<span class="fa"></span>';
            echo '</li>'." \n";
        }
    }
}
?>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _settings; ?>">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _fullscreen; ?>">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _lock; ?>" href="<?php echo "index.php?hash=". encrypturl("action=lockscreen"); ?>">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _logout; ?>" href="<?php echo "index.php?hash=". encrypturl("action=logout"); ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>