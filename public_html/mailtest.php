<?php
require "config.php";

$query="select email,verification from pending_store";
require (SRVROOT.'cr/dbconn.php');

$mails=array();
while (list($recip,$verify)=mysql_fetch_array($result)) {
	array_push($mails,array('recip'=>$recip,'verify'=>$verify));
}

$count=0;
foreach ($mails as $mail) {
	/*** send activation email ***/
	$time=date("H:i:s");
	$mail_recip=$mail['recip'];
	$mail_sender="\"CB Dealer Support\" <support@cbdealer.com>";
	$mail_subject="CB Dealer ClickBank Storefront activation";
	$mail_message="
	We apologize for the delay in sending your activation email. Apparently, certain free mail providers were blocking emails sent by our registration application. Although the problem has now been corrected, we suggest that you configure your email account to accept mail from support@cbdealer.com so that you are able to receive important communication from us regarding your account without delay.
	
	Please click on the link below to activate your CB Dealer ClickBank storefront. Once activated, you will be able to log in using the ClickBank nickname and password.

	http://www.cbdealer.com/activate.php?".$mail['verify']."

	After your store has been activated, you can log in anytime at http://www.cbdealer.com to customize the look of your store.
	
	Thanks for joining the CBDealer family! Best of luck with your store. Look for some exciting enhancements in the near future.
	
	Regards,
	The CBDealer Support Team
	
	";

//echo "$mail_recip<br />$mail_message<p />";

	require_once("/home/cbdlr/cr/swiftmlr.php");
	swiftmail($mail_recip,$mail_sender,$mail_subject,$mail_message);
	
	$count++;

}

echo "Sent $count emails";
?>