<?php
//Valid Input characters

function checkinput ($input){
	if ($input === ""){
		$output = "GAppsFactory";
	} else {
		$output = preg_replace('/\s+/', '', $input);
	}
	return $output;
}
?>