<?php

include"extractlibs.php";

function updatelibs($servergapps, $gappsdir){
	extractlibs("Core", $gappsdir);
	foreach ($servergapps as $gapps) {
		extractlibs($gapps, $gappsdir);
	}
}

?>