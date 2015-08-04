<?php
require("config.php");
if ($_POST['todo']=="update") {
	$query="insert into notify values ('".$_POST['email']."',now())";
	require (SRVROOT.'cr/dbconn.php');
	$message="Thanks. We'll let you know as soon as the ClickBank database service is launched";
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/includes/main.css" />
<script type="text/javascript" src="/includes/checkMail.js"></script>
<script type="text/javascript">
function checkForm() {
	if (!emailCheck(document.register.email.value)) {
		alert (document.register.email.value+' does not appear to be a valid email address');
		return;
	}
	document.register.submit();
}
</script>
<body style="background-color:#bce5ff">
<div align="center">
<h2>- Coming soon -</h2>
</div>
The new XML feed from the Clickbank Marketplace is a great idea, but if you'<!--'-->ve tried to work with it, you know what a pain it can be. Look in this space very soon for some pain relief. We'<!--'-->re taking the daily updated feed from ClickBank and converting it to something you can really use- tab and pipe delimited files for easy use with apps like Excel and MS Access, and a MySQL table that you can insert right into your own database. If you'<!--'-->d like for us to notify you when the service is launched (sometime in January 07), enter your email address below. We are intensely anti-spam, and we won'<!--'-->t use your address for anything else!
<p />
<div align="center"
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="register">
<input type="hidden" name="todo" value="update" />
<b>Email address:</b> <input type="text" name="email" value="<?=$_POST['email']?>" />
<p align="center" />
<input type="button" class="man_b" value="Notify me" onclick="checkForm()" />
</form>
<p align="center">
<?=$message?>
</div>
</body>
</html>
