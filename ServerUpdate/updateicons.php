<?php

include"extracticons.php";

$iconlocation = "../icons";

function updateicons($servergapps, $gappsdir, $iconlocation){
	foreach ($servergapps as $gapps) {
		extracticons($gapps, $gappsdir);
	}
}