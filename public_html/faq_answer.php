<?php
require("config.php");

$query="select answer from faq_item where id='".$_GET['id']."'";
require (SRVROOT.'cr/dbconn.php');
$answer=mysql_fetch_row($result);
echo $answer[0];

?>