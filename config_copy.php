<?php
$servername = "localhost";
$username = "root";
$password = "9054fed9620b4e11d9a307583e174204f06306a455c2b7fb";
$dbname = "egyptassist_db";

$session_timeout = 43200;
$lastactivite_timeout = 900;

$sys = "AMS";
$co = "Egypt Assist";
$co_sys = "Egypt Assist Portal";
$ver = "V1.0";
$lang = "en";
$rtl = True;
$enable_loging = 0;
$debug['print_sql'] = 1;
$debug['print_headers'] = 1;
$target_dir = "/var/www/html/ega/files/";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>