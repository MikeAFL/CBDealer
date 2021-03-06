<?php
require("config.php");
//showArray($_COOKIE);
//showArray($_POST);

/*
variable $show tracks the status of the user
we'll use $show to determine what to show him on this page
*/
$message="Current subscribers log in here";

if (isset($_POST['todo'])) {
	// user has submitted a form
	if (isset($_POST['sendpass'])) {
		// user has asked for password
		$query="select password from feed_users where email='".$_POST['uid']."'";
		require (SRVROOT.'cr/dbconn.php');
		if (mysql_num_rows($result)!=1) {
			$message="No valid user with email address ".$_POST['uid'];
			$show="login";
			$_POST['todo']="";
		} else {
			$user_data=mysql_fetch_assoc($result);
			// send the email
			$mail_recip=$_POST['uid'];
			$mail_sender="\"CB Dealer Support\" <support@cbdealer.com>";
			$mail_subject="Password Reminder";
			$mail_message="
			Your password is ".$user_data['password']." 

			";

			require("includes/swiftmlr.php");
			swiftmail($mail_recip,$mail_sender,$mail_subject,$mail_message);
			$message="Your password has been sent to ".$_POST['uid'];
			$show="login";
		}
	
	$_POST['todo']="";
	}

		
	switch ($_POST['todo']) {
		case "logout":
		reset_cookie();
		break;
		case "login":
		$query="select id,expire_date from feed_users where email='".$_POST['uid']."' and password='".$_POST['pw']."'";
		require (SRVROOT.'cr/dbconn.php');
		if (mysql_num_rows($result)!=1) {
			// invalid login
			$show="badlogin";
		} else {
			// set the cookie
			$user_data=mysql_fetch_assoc($result);
			setcookie("feed",$user_data['id']);
			header ("Location:http://www.cbdealer.com/df_dl.php");
			exit;
		}
		break;
	}
}
		

/******** CHECK FOR CURRENT LOGIN **************/

if (isset($_COOKIE['feed']) && !isset($show)) { //first check for a cookie
	// if there is a cookie check the account status
	$query="select email,expire_date from feed_users where id='".$_COOKIE['feed']."'";
	require (SRVROOT.'cr/dbconn.php');
	if (mysql_num_rows($result)!=1) {
		// this is not a valid login - delete the cookie and reload this page
		reset_cookie();
	} else {
		// see if this user has a current account
		$user_data=mysql_fetch_assoc($result);
		$expire=strtotime($user_data['expire_date']);
		$today=strtotime(date("Y-m-d"));
		if ($expire<$today) {
			/* if there is a cookie and the account is expired, give the user
			the expired message with an option to log out */
			$show="expired";
		} else {
			/* if there is a cookie and the account is current,
			give the user the option to log out */
			$message="You are logged in as ".$user_data['email'];
			$show="logout";
		}
	}
}

function reset_cookie() {
	// deletes the current cookie and reloads this page
	// do not call once headers have been sent
	setcookie("feed","",time()-3600);
	header ("Location:http://www.cbdealer.com/cb_feed.php");
	exit;
}

include (DOCROOT."includes/header.inc.php");

?>

<script type="text/javascript">
function setButton() {
	if (document.login.sendpass.checked) {
		document.login.send.value="SEND PASSWORD";
	} else {
		document.login.send.value="LOGIN";
	}
}

function checkForm() {
	if (!document.subscribe.term[0].checked && !document.subscribe.term[1].checked) {
		alert ('Please select a subscription term');
		focus(document.subscribe.term);
		return;
	}
	if (!emailCheck(document.subscribe.sub_email.value)) {
		alert (document.subscribe.sub_email.value+' does not appear to be a valid email address');
		return;
	}
	if (!document.subscribe.sub_password.value) {
		alert('Please enter a password');
		return;
	}
	if (!document.subscribe.agreed.checked) {
		alert('Please indicate your agreement to the terms');
		return;
	}
	document.subscribe.submit();
	
	
}
	
</script>

<h1>ClickBank<sub>&reg;</sub> MarketPlace Datafeed</h1>

<?php

switch ($show) {
	case "expired":
	$message="You are logged in to an expired account"
	?>
	<?=$show?>
	<?php
	// no break here- we want to show the logout button
	
	case "logout":
	?>
	<img src="/images/spacer.gif" width="1" height="260" align="right" />
	<p />
	<div align="center">
	<span style="color:#990000;font-weight:bold;">
	&nbsp;<?=$message?>&nbsp;
	</span>
	<p />
	<div align="center">
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<input type="hidden" name="todo" value="logout" />
	<p />
	<?php
	// only show this link if the login is valid
	if ($show=="logout") {
		echo "<a href=\"/df_dl.php\">Go to download page</a><p />";
	}
	?>
	<input type="submit" class="man_b" value="LOGOUT" />
	</form>
	<?php
	break;
	
	case "badlogin":
	$message="Invalid email/password";
	// no break here- we want to show the login screen

	default: // show the login screen
	?>
	<img src="/images/spacer.gif" width="1" height="260" align="right" />
	<p />
	<div align="center">
	<span style="color:#990000;font-weight:bold;">
	&nbsp;<?=$message?>&nbsp;
	</span>
	<p />
	<div align="center">
	<form style="display:inline" name="login" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<input type="hidden" name="todo" value="login" />
	<table cellpadding="6" cellspacing="0" border="0" align="center" style="border:1px solid #000066">
	<tr>
		<td align="right">Email address:</td>
		<td><input class="man_b" type="text" name="uid" value="<?$_POST['uid']?>" /></td>
		<td align="right">Password:</td>
		<td><input class="man_b" type="password" name="pw" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><b>Forgot password?</b>
		<br /><input type="checkbox" name="sendpass" onclick="javascript:setButton()" /> Send my password to this email address</td>
		<td colspan="2" align="center" />
		<input class="man_b" name="send" type="submit" value="LOGIN" />
		</td>
	</tr>
	</table>
	</form>
	

	<?php
}
?>
	</div>

<h2>Download the ClickBank<sub>&reg;</sub> MarketPlace Datafeed as<br />a tab or pipe delimited text file, or as a MySQL table.</h2>
<a href="#subscribe"><b>Subscribe Now!</b></a><p />
</div>
We'<!--'-->ve taken the hassle out of using the ClickBank<sub>&reg;</sub> MarketPlace XML Datafeed. Now you can download the entire ClickBank<sub>&reg;</sub> MarketPlace catalog in a format that you can easily work with. Use the delimited text files with MS Access or Excel, or to populate your own ClickBank<sub>&reg;</sub> MarketPlace application, or import the MySQL table into your database.
<p />
You can save hours of work for just pennies a day! Subscribe to our ClickBank<sub>&reg;</sub> MarketPlace Datafeed service and download any or all of the catalog files.
<h3>Updated daily</h3>
ClickBank<sub>&reg;</sub> publishes an updated XML file at 5amPT everyday. Our software grabs the new XML file, then builds and publishes the new datafeed files, all within an hour of the ClickBank<sub>&reg;</sub> update. The datafeed files are updated daily, so your ClickBank<sub>&reg;</sub> MarketPlace is always fresh.

<h3>Automate downloads</h3>
The ClickBank<sub>&reg;</sub> MarketPlace Datafeed files are directly available to your application. You can pass login credentials and the file request via a single URL. Encode the URL request in your application to automatically update your data.

<a name="subscribe"></a>
<h3>Subscribe now for immediate access</h3>
<b>Terms</b><br>
<span style="font-size:9px">
Your subscription is subject to these terms:
<ul>
	<li>Raw downloaded files are for your use only. You can use the files any way you wish, including reselling any application that incorporates processed data from the files. However, you may not make the raw files or data available to any third party in any manner.</li>
	<li>In order to control bandwidth consumption and keep subscription prices low, you are limited to two downloads per day of each of the files, for a daily total of up to six downloads. The second download is in case you have a problem with your initial download of any file. If you are unable to download a file after your second attempt, contatct <a href="http://www.s1m.com/support.html" target="_blank">S1M Support</a> and we will email the files to you.</li>
	<li>This service is entirely contigent on the availability of the ClickBank<sub>&reg;</sub> MarketPlace XML Datafeed. Source 1 Media will attempt to quickly mitigate any problem with the feed, but we assume no responsibility for problems with the feed beyond our control.</li>
	<li>The ClickBank<sub>&reg;</sub> MarketPlace XML Datafeed is updated daily at approximately 8:00am ET and the updated datafeed files are available for download at approximately 8:30am ET. Occasional problems with the ClickBank<sub>&reg;</sub> MarketPlace XML Datafeed may result in the updated datafeed files being posted at a later time.</li>
	<li>We will make every effort to ensure the integrity of the datafeed files. However, problems with the XML source may compromise the integrity and usability of the datafeed files. We strongly suggest that you retain the previous day'<!--'-->s files for rollback purposes, and verify the current files before using them. Source 1 Media accepts no responsibility for damages arising from the use of corrupted feed files.</li>
</ul>
</span>
<p />
<div align="center">
<noscript>
This subscription form requires JavaScript
</noscript>
<form name="subscribe" action="/cbfeed_subscribe.php" method="post" target="dark">
<input type="radio" name="term" value="monthly" /><b>Monthly</b> $4.95&nbsp;&nbsp;
<input type="radio" name="term" value="annual" /><b>Annual</b> $49.95<br />
<p />
<b>Email address</b> (this will be your login name): <input type="text" name="sub_email" value="<?=$_POST['sub_email']?>" />&nbsp;&nbsp;<b>Password</b>: <input type="password" name="sub_password" />
<p />
<input type="checkbox" name="agreed"><b>I agree to the above-stated terms.</b>
<p />
<span style="color:#990000"><b>Important:</b> After completing your subscription at PayPal, be sure to<br />click the 'Return To Merchant' button so that your account can be set up.</span>
<p />
<input type="button" class="man_b" value="Subscribe via PayPal" onclick="checkForm()" />
</form>
</div>

<iframe name="dark" width="0" height="0" frameborder="0" scrollbars="0"></iframe>


<?php

include (DOCROOT."includes/footer.inc.php");

?>

