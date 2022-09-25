<?php if(!isset($currentuserid)) header("Location:index.php"); ?>
<li role="presentation" class="nav-item dropdown open">
    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="badge bg-blue">6</span>
    </a>
    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
        <li class="nav-item">
            <a class="dropdown-item">
                <span class="image"><img src="assets/gentela/production/images/img.jpg" alt="Profile Image" /></span>
                <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="dropdown-item">
                <span class="image"><img src="assets/gentela/production/images/img.jpg" alt="Profile Image" /></span>
                <span>
                    <span>John Smith</span>
                    <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                    Film festivals used to be do-or-die moments for movie makers. They were where...
                </span>
            </a>
        </li>        
        <li class="nav-item">
            <div class="text-center">
                <a class="dropdown-item">
                    <strong><?php echo _see_all_alerts; ?></strong>
                    <i class="fa fa-angle-left"></i>
                </a>
            </div>
        </li>
    </ul>
</li>