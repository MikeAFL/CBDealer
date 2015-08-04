<?

function swiftmail($recip,$sender,$subject,$message) {
	
	if ($_SERVER['SERVER_ADDR']!="216.246.16.205") {
		echo "invalid access";
		exit;
	}
	
	//Load in the components
	$swiftpath="/home/mikeaflo/swift";
	require_once("$swiftpath/Swift.php");
	require_once("$swiftpath/Swift/Connection/SMTP.php");
	require_once("$swiftpath/Swift/Authenticator/LOGIN.php");

	//Instantiate swift
//	if (!isset($swift)) {
	$swift = new Swift(new Swift_Connection_SMTP("cbdealer.com",SWIFT_SECURE_PORT, SWIFT_TLS));
//	$sender="\"CB Dealer Support\" <support@cbdealer.com>";
//	}

	/**** authentication ******/
	$swift->loadAuthenticator(new Swift_Authenticator_LOGIN);
	$swift->authenticate("support@cbdealer.com","p3tty44");



	//Send the email
	$swift->send($recip, $sender, $subject, $message);

	//Terminate the connection because it"s just polite
	$swift->close();
	if ($subject=="CB Dealer ClickBank mail test") {
		echo "***************** TRANSACTIONS *********************<p />";
		showArray($swift->transactions);
		echo "<p />***************** ERRORS *********************<p />";
		showArray($swift->errors);
	}
	
	
}

