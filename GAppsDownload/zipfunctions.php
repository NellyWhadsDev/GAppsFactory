<?php

function zipadd($filetoadd, $zip){
	shell_exec("7za a ".$zip." ".$filetoadd);
}

function zipectract($filetoextract, $destination){
	shell_exec("7za x ".$filetoextract." -o".$destination);
}

function zipiconextract($apk, $icon, $destination){
	shell_exec("7za e -aoa ".$apk." -o".$destination." ".$icon);
}

?>