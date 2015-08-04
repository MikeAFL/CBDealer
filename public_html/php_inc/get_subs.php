<?php
require("/home/cbdlr/public_html/config.php");

if (!isset($_GET['cat'])) {
	echo "no cats here";
	exit;
}

$query="select distinct subcategory from cb_products where category='".$_GET['cat']."' and subcategory is not null and subcategory!=''";
require (SRVROOT.'cr/dbconn.php');

/*** build the option list ***/
echo "<option value=\"top\">Top Level Only</option>\n
<option value=\"all\">All</option>\n";
while (list($subcats)=mysql_fetch_array($result)) {
	echo "<option value=\"$subcats\">$subcats</option>\n";
}

?>