<?php
require("config.php");

if (!$_POST['cb_nick'] || !$_POST['email'] ||!$_POST['password'] || !$_POST['check_password']) {
	header ("Location:http://www.cbdealer.com");
	exit;
}

$query="select * from userdata where aff_link='".$_POST['cb_nick']."'";
require (SRVROOT.'cr/dbconn.php');
if (mysql_num_rows($result)<1) {
	$query="insert into userdata (aff_link,email,password) values ('".mysql_real_escape_string($_POST['cb_nick'])."','".mysql_real_escape_string($_POST['email'])."','".mysql_real_escape_string($_POST['password'])."')";
	require (SRVROOT.'cr/dbconn.php');
	$site=mysql_insert_id();
}

include (DOCROOT.'includes/header.inc.php');

if (!isset($site)) {

?>

<div align="center">
<h2>Duplicate Entry</h2>
There is already a CB Deals Storefront using the ClickBank nickname "<?php echo $_POST['cb_nick'] ?>".
<p />
<a href="/index.php">Go back</a>
<p />
</div>
<?php
} else {
	
?>

<div align="center">
<h2>Congratualtions!</h2>
<h3>Your ClickBank<sub>&reg;</sub> MarketPlace Affiliate Storefront is set up!</h3>
Your store is located at www.cbdeals.com/<?=$site ?>/<br />
Your login name is your ClickBank<sub>&reg;</sub> nickname. You can log in at the top of this page to customize the look of your store.
<p />
<a href="http://www.cbdeals.com/<?=$site ?>/"><b>Go to my store!</b></a>

<?php
}

include (DOCROOT.'includes/footer.inc.php');

?>