<?php

function starttimer(){
	global $starttime;
	$starttime	= microtime(true);
}

function endtimer($log, $logtext){
	global $endtime;
	$endtime = microtime(true);
	$executiontime = ($endtime - $starttime);
	file_put_contents($log, $logtext.' '.$executiontime.' Seconds'.PHP_EOL, FILE_APPEND);
}

?>