<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $co_sys; ?> | <?php echo $sys; ?> - <?php echo $ver; ?> </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="assets/login/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-85 p-b-20">
            <form class="login100-form validate-form" action="?page=check" method="post">
                <span class="login100-form-title p-b-30">
                    <?php echo $co_sys; ?><br><?php echo $sys; ?>
                </span>
                <span class="login100-form-avatar">
                    <img src="assets/login/images/egypt_assist_logo.jpg" alt="AVATAR">
                </span>
                <?php
                if(isset($_SESSION["login"]) and $_SESSION["login"] == "LOGIN_ERROR") {
                ?>
                <span class="login_error">
                    Sorry, Cannot log in to Admin Panel.
                </span>
                <?php
                }
                ?>
                <div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "<?php echo _enter_username; ?>">
                    <input class="input100" type="text" name="username">
                    <span class="focus-input100" data-placeholder="<?php echo _username; ?>"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-50" data-validate="<?php echo _enter_pass; ?>">
                    <input class="input100" type="password" name="pass">
                    <span class="focus-input100" data-placeholder="<?php echo _pass; ?>"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        <?php echo _login; ?>
                    </button>
                </div>
                <div><center><?php echo _poweredby; ?></center></div>
            </form>

        </div>

    </div>

</div>

<div id="dropDownSelect1"></div>
            <!-- footer content -->

<!--===============================================================================================-->
<script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="assets/login/vendor/bootstrap/js/popper.js"></script>
<script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="assets/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="assets/login/vendor/daterangepicker/moment.min.js"></script>
<script src="assets/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="assets/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="assets/login/js/main.js"></script>

</body>
</html>
