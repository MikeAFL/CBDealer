<?php

require ("config.php");
/*** initialize db connection ***/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

if (isset($_POST['todo']) && $_POST['todo']=="send") {
	$user=mysql_real_escape_string($_POST['user']);
	$query="select email from userdata where aff_link='$user'";
	require (SRVROOT.'cr/dbconn.php');
	if (mysql_num_rows($result)!=1) {
		$message="User not found";
	} else {
		/*** get a random verification code ***/
		$email=mysql_fetch_row($result);
		require(DOCROOT."includes/randpass.php");
		$auth=pass_gen();
		
		/*** insert a db record ***/
		$query="insert into pwrst (user_id,auth,date) values ('$user','$auth',now())";
		require (SRVROOT.'cr/dbconn.php');
		/*** send an email ***/
		$mail_recip=$email[0];
		$mail_sender="\"CB Dealer Support\" <support@cbdealer.com>";
		$mail_subject="CB Dealer password reset";
		$mail_message="
		Please click on the link below to reset your CB Dealer account password.

		http://www.cbdealer.com/rstpw.php?auth=$auth

		";

		require("/home/cbdlr/cr/swiftmlr.php");
		swiftmail($mail_recip,$mail_sender,$mail_subject,$mail_message);
		
		/*** set the message ***/
		$success=true;
		$message="An email has been sent with a link to reset your password.<p />
		<input type=\"button\" class=\"man_b\" value=\"CLOSE\" onclick=\"window.close();\" />";
	}
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/includes/main.css" />
<script type="text/javascript">
function checkForm() {
	if (!document.getpw.user.value) {
		alert('Please enter your ClickBank ID');
		return;
	}
	document.getpw.submit();
}
</script>
<title>CB Dealer Password Reset</title>
</head>

<body>

<div align="center" />

<span class="error">&nbsp;<?=$message?>&nbsp;</span>
<p />

<?php
	/****************************/
if (!isset($success)) {
	?>
<script type="text/javascript">
function getDF() {
	opener.location.href='/cb_feed.php';
	window.close();
}
</script>
	
Please enter your ClickBank ID below.<br />
An email will be sent to the address we have on file.<br />
<span class="small"><i>To recover your datafeed password, please go to the <a href="#" onclick="getDF()">datafeed page</a>.</i></span>
<p />
<form name="getpw" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="todo" value="send" />
<b>ClickBank ID:</b> <input type="text" class="man_b" name="user" value="<?=$_POST['user']?>" />
<p />
<input type="button" class="man_b" value="SEND EMAIL" onclick="checkForm()" />
</form>
</div>
 
	<?php
}
	/***************************/
?>

</body>
</html>