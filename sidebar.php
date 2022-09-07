<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="?page=home" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $co; ?> !</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="assets/gentela/production/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span><?php echo _welcome; ?>,</span>
                <h2><?php echo $user['user_name']; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <!--<h3>General</h3>-->
                <ul class="nav side-menu">
                    <li id="link1"><a href="?page=home"><i class="fa fa-home"></i><?php echo _home; ?><span class="fa"></span></a></li>    
                    <li id="gro1"><a><i class="fa fa-cubes-stacked"></i><?php echo _stores_managment; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">   
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _categories; ?><span class="fa"></span></a>
                            </li>
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _items; ?><span class="fa"></span></a>
                            </li>                         
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _stores; ?><span class="fa"></span></a>
                            </li>
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _stock; ?><span class="fa"></span></a>
                            </li>                         
                        </ul>
                    </li>
                    <li id="gro1"><a><i class="fa fa-id-card"></i><?php echo _suppliers_and_clients; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">                            
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _suppliers; ?><span class="fa"></span></a>
                            </li>  
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _clients; ?><span class="fa"></span></a>
                            </li>                                                     
                        </ul>
                    </li>
                    <li id="gro1"><a><i class="fa fa-file-invoice-dollar"></i><?php echo _sells_and_purchases; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">                            
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _sells; ?><span class="fa"></span></a>
                            </li>    
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _purchases; ?><span class="fa"></span></a>
                            </li>                        
                        </ul> 
                    </li>
                    <li id="gro1"><a><i class="fa fa-calculator"></i><?php echo _accounting; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">                            
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _suppliers; ?><span class="fa"></span></a>
                            </li>                          
                        </ul> 
                    </li>
                    <li id="gro1"><a><i class="fa fa-people-group"></i><?php echo _emps_managment; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">                            
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _suppliers; ?><span class="fa"></span></a>
                            </li>                          
                        </ul>
                    </li>    
                    <li id="gro1"><a><i class="fa fa-file-pdf"></i><?php echo _reports; ?><span class="fa fa-chevron-down"></span></a>
                        <ul id="ulgro1" class="nav child_menu" style="display: none;">                            
                            <li id="link3">
                                <a href="?page=caselist&status=9"><i class="fa"></i><?php echo _suppliers; ?><span class="fa"></span></a>
                            </li>                          
                        </ul> 
                    </li> 
                    <li id="link1"><a href="?page=home"><i class="fa fa-building"></i><?php echo _companies; ?><span class="fa"></span></a></li> 
                    <li id="link1"><a href="?page=home"><i class="fa fa-users"></i><?php echo _users_managment; ?><span class="fa"></span></a></li> 
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
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _lock; ?>">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="<?php echo _logout; ?>" href="?page=logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>