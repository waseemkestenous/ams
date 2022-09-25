<?php

$url='index.php?mod=users&page=dash&action=add&id=1';
/*
cipher = "AES-128-CTR";
$ciphertext = openssl_encrypt($url, $cipher,'361472');
echo $ciphertext;
    $orgtext = openssl_decrypt($ciphertext, $cipher,'361472');
echo"<br>";
echo $orgtext;
echo"<br>";
*/

echo $url;
echo"<br>";
echo $hash =base64_encode($url);
echo"<br>";
echo $hash =base64_encode($hash);
echo"<br>";
echo $url =base64_decode('Ylc5a1BXTnZiWEJoYm1sbGN5WndZV2RsUFhWelpYSmpieVpwWkQwMkptRmpkR2x2YmoxaFpHUT0=');
echo"<br>";
echo $url =base64_decode($url);


//echo $gzdata = gzencode($url, 9);

//echo $urlencode = urlencode($url);