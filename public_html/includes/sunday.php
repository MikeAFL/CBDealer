<?php

require ("get_sunday.php");

for ($x=1;$x<6;$x++) {
	echo $x." -- ".get_sunday($x)."<br />";
}

?>
