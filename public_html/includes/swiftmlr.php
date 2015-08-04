<?

function swiftmail($recip,$sender,$subject,$message) {
	
	if ($_SERVER['SERVER_ADDR']!="216.246.16.205") {
		echo "invalid access";
		exit;
	}
	
	//Load in the components
	$swiftpath="/home/mikeaflo/swift";
	require("$swiftpath/Swift.php");
	require("$swiftpath/Swift/Connection/SMTP.php");

	//Instantiate swift
	$swift = new Swift(new Swift_Connection_SMTP("cbdealer.com"));
//	$sender="\"CB Dealer Support\" <support@cbdealer.com>";

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

