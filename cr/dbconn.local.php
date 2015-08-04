<?php
$host="localhost";

/*** DB info ***/
$dbname="clubtech_cbdata";
$dbuser="clubtech_cbdata";
$dbpw="petty44";
/***************/

$link = mysql_connect($host,$dbuser,$dbpw);
if (!$link) {
   die('Could not connect: ' . mysql_error());
}
$db = mysql_select_db($dbname,$link);
if (!$db) {
   die ("Database connection error : " . mysql_error());
}


$result = mysql_query($query);
if (!$result) {
   die('Invalid query: ' . mysql_error());
}

?>
