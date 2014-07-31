<?php

include"zipfunctions.php";

function zipgapps($gappslist, $gappsname, $gappspath){
//uses 7zip to add core directory + each directory pertaining to the user's request to the zip file

	zipadd($gappspath."/Core/*", $gappsname);
	zipadd($gappspath."/META-INF", $gappsname);
	zipadd($gappspath."/utils", $gappsname);
	
	foreach ($gappslist as $gapps) {
		zipadd($gappspath."/".$gapps."/*", $gappsname);
    }
}

?>