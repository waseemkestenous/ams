<?php if(!isset($currentuserid)) header("Location:index.php?page=home"); ?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <title><?php echo $co_sys; ?> | <?php echo $sys; ?> - <?php echo $ver; ?> </title>
    <!--===============================================================================================-->    
    <link rel="icon" type="image/png" href="assets/custom/images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <!-- Bootstrap -->
    <link href="assets/gentela/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--===============================================================================================-->
    <!-- Font Awesome -->
    <link href="assets/gentela/vendors/fontawesome_6.2/css/all.css" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="assets/gentela/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!--===============================================================================================-->
<?php 
$ltr = "";
if(isset($rtl) && $rtl) { 
    $ltr = "-rtl";
?>
    <!-- rtl Style -->
    <link href="assets/custom/css/rtl.css" rel="stylesheet">
<?php } ?>
    <!-- Custom Theme Style -->
    <link href="assets/gentela/build/css/custom<?php  echo $ltr; ?>.css" rel="stylesheet">
    <!--===============================================================================================-->
    <?php echo $header_code; ?>
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">