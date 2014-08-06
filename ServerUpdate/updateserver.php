<?php

include"updatelibs.php";
include"updateicons.php";

$gappsdir = "../files";
$servergapps = array_diff(scandir($gappsdir), array('.', '..'));

updatelibs($servergapps, $gappsdir);
updateicons($servergapps, $gappsdir);



?>