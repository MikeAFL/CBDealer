<?php
require("config.php");

/**** for testing***********/
//$_POST['cb_nick']="test9";$_POST['email']="mike@s1m.com";$_POST['password']="1234";$_POST['check_password']="1234";
/************************/

if (!$_POST['cb_nick'] || !$_POST['email'] ||!$_POST['password'] || !$_POST['check_password']) {
	header ("Location:http://www.cbdealer.com");
	exit;
}

include_once (DOCROOT.'includes/header.inc.php');
echo "<img src=\"/images/spacer.gif\" width=\"1\" height=\"320\" align=\"right\" />";


$query="select * from userdata u,pending_store p where u.aff_link='".$_POST['cb_nick']."' or p.aff_link='".$_POST['cb_nick']."'";
require (SRVROOT.'cr/dbconn.php');
if (mysql_num_rows($result)>0) {

	
	?>

	<div align="center">
	<h2>Duplicate Entry</h2>
	There is already a CB Dealer Account using the ClickBank nickname "<?php echo $_POST['cb_nick'] ?>".
	<p />
	<a href="/index.php">Go back</a>
	<p />
	</div>
	<?php
} elseif ($_POST['password']!=$_POST['check_password']) {
	?>

	<div align="center">
	<h2>Password Mismatch</h2>
	The passwords you entered don'<!--'-->t match.
	<p />
	<a href="/index.php">Go back</a>
	<p />
	</div>
	<?php
} else {	
	
	/*** get a random verification code ***/
	require(DOCROOT."includes/randpass.php");
	$verification=pass_gen();

	/*** insert the pending store record ***/
	$query="insert into pending_store values ('".mysql_real_escape_string($_POST['cb_nick'])."',now(),'".mysql_real_escape_string($_POST['email'])."','".mysql_real_escape_string($_POST['password'])."','$verification','".mysql_real_escape_string($_POST['src'])."')";
	require (SRVROOT.'cr/dbconn.php');
	

	/*** send activation email ***/
	$mail_recip=$_POST['email'];
	$mail_sender="\"CB Dealer Support\" <support@cbdealer.com>";
	$mail_subject="CB Dealer account activation";
	$mail_message="
	Please click on the link below to activate your CB Dealer account. Once activated, you will be able to log in using the User ID (your ClickBank nickname) and password you entered when you signed up.

	http://www.cbdealer.com/activate.php?$verification

	After your account has been activated, you can log in anytime at http://www.cbdealer.com to build ClickBank Ads and to customize the look of your store.
	
	";

	require("/home/cbdlr/cr/swiftmlr.php");
	swiftmail($mail_recip,$mail_sender,$mail_subject,$mail_message);



	?>

	<div align="center">
	<h2>Thank You!</h2>
	An email has be sent to <?=$mail_recip?>. Please activate your account by clicking the activation link in the email.
	<p />


	<?php
}

include (DOCROOT.'includes/footer.inc.php');

?>