<?php 
if(!isset($currentuserid)) {
    header("Location:index.php");die();
}
check_perms();

echo '<script>'."\n";
echo 'link = document.getElementById("link-' . $mod . '");' . "\n";
echo 'if(link) { link.classList.add("current-page"); }' . "\n";
echo '</script>'."\n";