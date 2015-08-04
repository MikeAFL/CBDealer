<?php

$date=getdate();
echo "<p />".$date['wday']."<p />";

$now = time();
$num = date("w");

echo "$now<br />$num";
$sunday=14-$num;
$last_sun=mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sunday, date("Y", $now));
echo "<p />$last_sun<p />";
$todayh = getdate($last_sun);
$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
echo "$m-$d-$y";


function get_sunday($back) {
	/*****************************************
	Gets previous sundays
	Usage: $back is how many sundays to go back
	1 is last Sunday, 2 is Sunday before, etc
	******************************************/
	$now = time();
	$num = date("w");
	$sunday=($back*7)-$num;
	$last_sun=mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sunday, date("y", $now));
	$todayh = date("mdy",$last_sun);
/*	$m = $todayh[mon];
	$d = $todayh[mday];
	$y = $todayh[year];*/
	return $todayh;
}

echo "<p />_".get_sunday(3)


?>