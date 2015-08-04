<?php
 
if ($_SERVER['REMOTE_ADDR']!="69.165.225.119") {
	header("Location:http://www.cbdealer.com");
} else {

$recips=array();
//$user_data=array('support@s1m.com','1100',"mike@s1m.com",'1101',"mikea@s1m.com",'1102');

$query="select site,email from userdata";
require ("/home/cbdlr/cr/dbconn.php");

while (list($site,$add)=mysql_fetch_array($result)) {
	array_push($recips,array('site'=>$site,'add'=>$add));
}


foreach ($recips as $recip) {
	$add=$recip['add'];
	$site=$recip['site'];
	
	require ("mail010507-1.php");

	//Load in the components
	$swiftpath="/home/mikeaflo/swift";
	require("$swiftpath/Swift.php");
	require("$swiftpath/Swift/Connection/SMTP.php");

	//Instantiate swift
	$swift = new Swift(new Swift_Connection_SMTP("cbdealer.com"));
	$sender="\"CB Dealer Support\" <support@cbdealer.com>";

	//Send the email
	$swift->send($add, $sender, "The subject", $text);

	//Terminate the connection because it"s just polite
	$swift->close();
	
	echo "sent mail to $add, site $site<br />\n";
	flush();
}
 

echo "<p />done";

}

?> 