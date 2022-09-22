<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <nav class="nav navbar-nav">
            <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="assets/gentela/production/images/img.jpg" alt=""><?php echo $user['user_name']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <!--<a class="dropdown-item"  href="javascript:;"> <?php echo T('_profile'); ?></a>
                        <a class="dropdown-item"  href="javascript:;">
                            <span class="badge bg-red pull-right">50%</span>
                            <span><?php echo T('_settings'); ?></span>
                        </a>
                        <a class="dropdown-item"  href="javascript:;"><?php echo T('_help'); ?></a>-->
                        <a class="dropdown-item"  href="?action=logout"><i class="fa fa-sign-out pull-right"></i><?php echo T('_logout'); ?></a>
                    </div>
                </li>

                <?php
                include "notifications.php";
                ?>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->