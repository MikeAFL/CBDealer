<?php

//$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-30, date("Y"));

	$lastmonth  = mktime(0, 0, 0, date("m")  , date("d")-30, date("Y"));
	$lastmonth=date("Y-m-d",strftime($lastmonth));
echo $lastmonth;

?>