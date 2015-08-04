<?php
require("config.php");

include (DOCROOT."includes/header.inc.php");
//showArray($_POST);

/**** check for a valid order ****/

if (!isset($_POST['subscr_id']) || ($_POST['amount3']!="4.95" && $_POST['amount3']!="49.95")) {
	$message="<div align=\"center\"><p />There was a problem with processing your order. Please contact <script type='text/javascript'>setAddress();</script>Source 1 Media support</a>.<br />Be sure to include the email address you used to sign up with.</div>";
} else {

	/*** see if this user has a current account ***/
	$query="select id,expire_date from feed_users where email='".$_POST['option_selection1']."'";
	require(SRVROOT."cr/dbconn.php");
	if (mysql_num_rows($result)==1) {
		$user_data=mysql_fetch_assoc($result);
		$expire=strtotime($user_data['expire_date']);
		$today=strtotime(date("Y-m-d"));
		if ($expire>=$today) {
			$expire_date=$user_data['expire_date'];
		} else { // this is an expired account - get rid of it and start over
			$query="delete from feed_users where id='".$user_data['id']."'";
			require(SRVROOT."cr/dbconn.php");
		}
	}
	isset($expire_date)?$start_date=$expire_date:$start_date=date("Y-m-d");
	
		
	
	/*** calculate the term based on the subscription amount ***/
	if ($_POST['amount3']=="49.95") {
//		$expiry="DATE_ADD(CURDATE(),INTERVAL 1 year)";
		$expiry="DATE_ADD('$start_date',INTERVAL 1 year)";
		$term="annual";
	} elseif ($_POST['amount3']=="4.95") {
//		$expiry="DATE_ADD(CURDATE(),INTERVAL 1 month)";
		$expiry="DATE_ADD(CURDATE(),INTERVAL 1 month)";
		$term="monthly";
	}
	

	/**** add user to db ****/

	if (isset($expire_date)) { // this is a renewal
		$query="update feed_users set email='".$_POST['option_selection1']."',password='".$_POST['custom']."',term='$term',expire_date=$expiry,subscr_id='".$_POST['subscr_id']."' where id='".$user_data['id']."'";
	} else { // this is a new user
		$query="insert into feed_users (email,password,signup_date,term,expire_date,subscr_id,first_name,last_name,payer_id) values ('".$_POST['option_selection1']."','".$_POST['custom']."',now(),'$term',$expiry,'".$_POST['subscr_id']."','".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['payer_id']."')";
	}
//echo $query;
	require(SRVROOT."cr/dbconn.php");
	
}

echo "<img src=\"/images/spacer.gif\" width=\"1\" height=\"320\" align=\"right\" />\n";


if (isset($message)) {
	
	?>

	<script type="text/javascript">
	function setAddress() {
		var prot="mailto:";
		var recip="support";
		var at="@";
		var domain="s1m.com";
		var tag="?subject=ClickBank Datafeed Signup Problem";
		document.write('<a href="'+prot+recip+at+domain+tag+'">');
	}
	</script>
	
	
	<?php
	echo $message;
} else {
	?>
	
	<div align="center">
	<p />
	<h3>Thank you for your subscription.</h3>
	You can access the datafeed download page immediately by logging<br />
	in using your username (email address) and password on <a href="/cb_feed.php">this page</a>
	
	<?php
	if (isset($_POST['option_selection2'])) {
		?>
		<p />
		Please allow 1-2 business days for your FTP account to be activated.<br />
		After that time, you will be able to access the datafeed files by FTP using your username (email address) and password.
		<?php
	}
	
	echo "\n</div>";
}

include (DOCROOT."includes/footer.inc.php");
	

?>
	