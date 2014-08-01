<?php

//Includes
include"checkinput.php";
include"zipgapps.php";
include"generatescripts.php";
include"signgapps.php";

//Path for GApps
$gappspath = "D:/xampp/htdocs/gappsfactory/7GApps";

//Path for Resources
$respath = "D:/xampp/htdocs/gappsfactory/Resources";

//execution time (start)
$starttime	= microtime(true);

//GApps list array
$postgapps = $_POST["gapps2zip"];

//Username
$postname = checkinput($_POST["user"]);

//GApps File Name
$gappsfile = $postname.'-customGApps-'.date("Ymd").'.zip';

zipgapps($postgapps, $gappsfile, $gappspath);

generatescripts($postgapps, $gappsfile);

signgapps($gappsfile, $respath);

header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename=$gappsfile");
    header('Content-Length: ' . filesize($gappsfile));
    header("Location: $gappsfile");

//unlink($gappsfile); TODO

//execution time (end)
	$endtime = microtime(true);
	$executiontime = ($endtime - $starttime);
	file_put_contents($respath.'/Log.txt', $gappsfile.' Generation Time: '.$executiontime.' Seconds'.PHP_EOL, FILE_APPEND);
?>