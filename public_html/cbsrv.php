<?php
require "config.php";

/*** initialize the db connection ***/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

/*** clean the input in the get string ***/
$ad=array_keys($_GET);
$ad=$ad[0];
$ad=explode("_",$ad);
$aff_id=mysql_real_escape_string($ad[0]);
$vend_id=mysql_real_escape_string($ad[1]);

/*** get the affiliate and vendor ids ***/
$query="select a.user_nick,p.id from ads a,cb_products p where a.id='$aff_id' and p.pk_id='$vend_id'";
require (SRVROOT.'cr/dbconn.php');



/*** construct the url - if we didn't get a valid db return, go to cbdealer.com ***/
if (mysql_num_rows($result)!=1) {
	$url="http://www.cbdealer.com";
} else {
	$site=mysql_fetch_row($result);
	/**** insert a db record for the click *****/
	$query="insert into ad_clicks (block,user_ip,date,url,vendor) values ('".$ad[0]."','".$_SERVER['REMOTE_ADDR']."',now(),'".$_SERVER['HTTP_REFERER']."','".$site[1]."')";
	require (SRVROOT.'cr/dbconn.php');
	
	$url="http://".$site[0].".".$site[1].".hop.clickbank.net";
}

/*** go to the page ***/
header("Location:$url");

?>
