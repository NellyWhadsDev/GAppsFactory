<?php

include_once"../GAppsDownload/zipfunctions.php";
include"rmdirr.php";

function extractlibs($gapp, $gappsdir){
	
	$di = new RecursiveDirectoryIterator($gappsdir."/".$gapp);
	foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
		if (pathinfo($filename)["extension"] == "apk") {
			$extractpath = $gappsdir."/extracted/".basename($filename, ".apk");
			
			zipextract($filename, $extractpath);
			
			if(is_dir($extractpath."/lib")){
				$files = array_diff(scandir($extractpath."/lib"), array('.', '..'));
				foreach($files as $scanned) {
					echo $scanned." <br/>";
					if(substr( $scanned, 0, 3 ) == "arm"){
						$src = $extractpath."/lib/".$scanned;
						$dst = $gappsdir."/".$gapp."/system/lib";
						if (!is_dir($dst)) {
							mkdir($dst);
						}
						foreach(glob($src."/*.*") as $lib){
							$systemlib = str_replace($src,$dst,$lib);
							copy($lib, $systemlib);
						}
					}
				}
			}
			rmdirr ($extractpath);//******************
		}
	}
	
}
	?>