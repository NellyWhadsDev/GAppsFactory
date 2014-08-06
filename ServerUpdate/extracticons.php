<?php

include_once"../GAppsDownload/zipfunctions.php";

function extracticons($gapp, $gappsdir, $destination){
	
	$di = new RecursiveDirectoryIterator($gappsdir."/".$gapp);
	foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
		if (pathinfo($filename)["extension"] == "apk") {
		
		$icon = shell_exec("aapt d badging ".$filename." | grep -oP \"application-icon-640:'\K[^']+\"");
		
		zipiconextract($filename, $icon, $destination);
		$iconfile = preg_replace('/^res\/mipmap-xxhdpi\//', '', $icon);
		rename($destination."/".$iconfile, $destination."/".$gapp.".png");
		
		}
	}
	
}
?>