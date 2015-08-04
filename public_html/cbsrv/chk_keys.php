<?php
require "../config.php";

if (!isset($_GET['keywords']) || $_GET['keywords']==='') {
	echo "<span style=\"color:#990000\"><b>No keywords entered</b></span>";
	exit;
}

/**** initialize the db connection for mysql_real_escape_string ****/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

$keys=explode(",",$_GET['keywords']);
$join=mysql_real_escape_string($_GET['join']);
$query="select count(distinct id) from cb_products where ";

for ($i=0;$i<count($keys);$i++) {
	$query.="(title like '%".trim(mysql_real_escape_string($keys[$i]))."%' or description like '%".trim(mysql_real_escape_string($keys[$i]))."%') $join ";
}
$query=rtrim($query," ".$join);
require (SRVROOT.'cr/dbconn.php');
$count=mysql_fetch_row($result);
switch ($join) {
	case "and":
	$conj="all";
	break;
	case "or":
	$conj="at least one";
}
echo "<span style=\"color:#000099\">$count[0] unique products match $conj of your keywords</span>";
?>