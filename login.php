<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $co_sys; ?> | <?php echo $sys; ?> - <?php echo $ver; ?> </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="assets/login/css/main.css">
        <!--===============================================================================================-->
<?php if(isset($rtl) && $rtl) { ?>
        <!-- rtl Style -->
        <link href="assets/custom/css/rtl.css" rel="stylesheet">
<?php } ?>
    </head>
    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-85 p-b-20">
                    <form class="login100-form validate-form" action="?action=check" method="post">
                        <span class="login100-form-title p-b-30">
                            <?php echo $co_sys; ?><br><?php echo $sys; ?>
                        </span>
                        <span class="login100-form-avatar">
                            <img src="images/logo.jpg" alt="AVATAR">
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
                            <input autocomplete="off" class="input100" type="text" name="username">
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
                        <div class="copyrights"><center><?php echo _poweredby; ?></center></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- footer content -->
        <!--===============================================================================================-->
        <script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="assets/login/js/main.js"></script>
    </body>
</html>
