<?php
require ("config.php");

/***** check for valid access *****/
if (isset($_COOKIE['feed'])) { // look for a cookie
	$query="select id,expire_date from feed_users where id='".$_COOKIE['feed']."'";
} elseif (isset($_REQUEST['uid']) && isset($_REQUEST['pw'])) { // look for a query string
	$query="select id,expire_date from feed_users where email='".$_REQUEST['uid']."' and password='".$_REQUEST['pw']."'";
}
require (SRVROOT.'cr/dbconn.php');

// if we don't get a valid resultset from the db, just bail
if (mysql_num_rows($result)!=1) {
	exit;
}

// check that the account is current
$user_data=mysql_fetch_assoc($result);
$expire=strtotime($user_data['expire_date']);
$today=strtotime(date("Y-m-d"));
if ($expire<$today) {
	exit;
}

// if we got this far, the login and account are ok

/****** check for download limit *******/
$file=$_REQUEST['file'];
$now=date("Y-m-d H:i:s");
$query="select * from feed_dls where id='".$user_data['id']."' and file='$file' and date_time>date_sub(now(), interval 1 day)";
require (SRVROOT.'cr/dbconn.php');
if (mysql_num_rows($result)>=2) {
	// download limit is exceeded for this file
	echo "<script type=\"text/javascript\">
	alert('You are limited to two downloads of this file within 24 hours.\\nPlease try again later or contact\\nSource 1 Media support for assistance.\\nhttp://www.s1m.com/support.html');
	</script>";
	exit;
}

// if we're still going then everything's good

/***** send the file *****/
$fileurl="/home/cbdlr/catalog/$file";
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"".$file."\";");
header('Content-Length: ' . filesize($fileurl));
readfile($fileurl);

/***** record the download in the db *****/
$query="insert into feed_dls values ('".$user_data['id']."','".$_SERVER['REMOTE_ADDR']."',now(),'$file')";
require (SRVROOT.'cr/dbconn.php');
?>






