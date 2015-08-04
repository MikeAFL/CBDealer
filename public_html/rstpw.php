<?php

if (!isset($_GET['auth']) && (!isset($_POST['todo']) || $_POST['todo']!="reset")) {
	/**** this is an unauthorized access ****/
	header ("Location:http://www.cbdealer.com");
	exit;
}

require("config.php");
/*** establish the db connection ***/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

/************************************************
Check for a valid auth string. If present, this user came
in from an email link
*****************************************************/
if (isset($_GET['auth'])) {
	$auth=mysql_real_escape_string($_GET['auth']);
	$query="select user_id from pwrst where auth='$auth'";
	require (SRVROOT.'cr/dbconn.php');
	if (mysql_num_rows($result)!=1) {
		/**** no valid auth found in the db - bounce the user ****/
		header ("Location:http://www.cbdealer.com");
		exit;
	}

	$user_id=mysql_fetch_row($result);
} elseif (isset($_POST['todo']) && $_POST['todo']=="reset" && isset($_POST['pw']) && isset($_POST['user'])) {
	/**** update the password - show the success message ****/
	$query="update userdata set password='".mysql_real_escape_string($_POST['pw'])."' where aff_link='".mysql_real_escape_string($_POST['user'])."'";
	require (SRVROOT.'cr/dbconn.php');
	$query="delete from pwrst where user_id='".mysql_real_escape_string($_POST['user'])."'";
	require (SRVROOT.'cr/dbconn.php');
	$success=true;
}
	

include (DOCROOT."includes/header.inc.php");


?>
<img src="/images/spacer.gif" width="1" height="320" align="right" />

<?php
/***** show the form if the user got here with a valid auth string *****/
if (!isset($success)) {
	?>

<script type="text/javascript">
function checkForm() {
	if (!document.rstPW.pw.value || !document.rstPW.pwc.value) {
		alert ('Please complete both password entries');
		return;
	}
	if (document.rstPW.pw.value!=document.rstPW.pwc.value) {
		alert ('Password entries don\'t match');
		return;
	}
	document.rstPW.submit();
}
</script>

<p />
<form name="rstPW" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="todo" value="reset" />
<input type="hidden" name="user" value="<?=$user_id['0']?>" />
<table cellpadding="6" cellspacing="0" border="0" align="center">
<tr>
	<td colspan="2" align="center"><b>Enter a new password for <?=$user_id['0']?></b></td>
</tr>
<tr>
	<td align="right"><b>New password:</b> </td>
	<td><input type="password" class="man_b" name="pw" /></td>
</tr>
<tr>
	<td align="right"><b>Confirm password:</b> </td>
	<td><input type="password" class="man_b" name="pwc" /></td>
</tr>
<tr>
	<td colspan="2" align="center">
	<input type="button" class="man_b" value="RESET PASSWORD" onclick="checkForm()" />
	</td>
</tr>
</table>
</form>

	<?php
} elseif ($success==true) {
	
	/**** show the success message if we changed the password ****/
	echo "<div align=\"center\">
	<b>Your password has been reset.<br />
	You can log in using your new password.
	</div>";
}
?>



<?php

include (DOCROOT."includes/footer.inc.php");

?>

