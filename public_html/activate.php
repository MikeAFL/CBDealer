<?php
require("config.php");

$verify=array_keys($_GET);
$verification=$verify[0];
$query="select aff_link,email,password,src from pending_store where verification='$verification'";
//echo $query;
require (SRVROOT.'cr/dbconn.php');
$newuser=mysql_fetch_assoc($result);
$valid=mysql_num_rows($result);
include_once (DOCROOT.'includes/header.inc.php');
echo "<img src=\"/images/spacer.gif\" width=\"1\" height=\"320\" align=\"right\" />";

if ($valid!=1) {
	?>
	
	<div align="center">
	<h2>Invalid verification code</h2>
	The verification code is invalid.
	
	<?php
} else {
	
	/*** insert the db record for this store ***/
	$query="insert into userdata (aff_link,email,password,src,date) values ('".$newuser['aff_link']."','".$newuser['email']."','".$newuser['password']."','".$newuser['src']."',now())";
	require (SRVROOT.'cr/dbconn.php');
	$site=mysql_insert_id();
	
	/*** delete the pending record for this store ***/
	$query="delete from pending_store where verification='$verification'";
	require (SRVROOT.'cr/dbconn.php');
	
	?>

	<div align="center">
	<h2>Your CB Dealer account has been activated</h2>
	You storefront is set up, and you can log in to your account at the top of any page to access the ClickBank Ad Builder.
	<p />
	Your ClickBank<sub>&reg;</sub> MarketPlace Affiliate Storefront is located at http://www.cbdeals.com/<?=$site ?>/<p />
	Your login name is your ClickBank<sub>&reg;</sub> nickname. Log in at the top of this page to customize the look of your store.
	<p />
	<a href="http://www.cbdeals.com/<?=$site ?>/"><b>Go to my store!</b></a>
	
	<?php
}

include_once (DOCROOT.'includes/footer.inc.php');

?>