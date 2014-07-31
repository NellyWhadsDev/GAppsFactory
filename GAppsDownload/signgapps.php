<?php

function signgapps($gappsname, $respath){
	$signedgapps = preg_replace('/\.zip/', '-signed$0', $gappsname);
	shell_exec('java -jar '.$respath.'/signapk.jar '.$respath.'/certificate.pem '.$respath.'/key.pk8 '.$gappsname.' '.$signedgapps);
	global $gappsfile;
	$gappsfile = $signedgapps;
	unlink($gappsname);
}

?>