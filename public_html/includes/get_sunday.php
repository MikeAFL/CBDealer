<?php

function get_sunday($back) {
	/*****************************************
	Gets previous sundays
	Usage: $back is how many sundays to go back
	1 is last Sunday, 2 is Sunday before, etc
	******************************************/
	$now = time();
	$num = date("w");
	$sunday=($back*7)-$num-1;echo $sunday." ";
	$last_sun=mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sunday, date("y", $now));
	$todayh = date("mdy",$last_sun);
	return $todayh;
}


?>