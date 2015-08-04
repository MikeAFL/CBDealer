<?php
require("config.php");

/*** check for logout request ***/
if (isset($_POST['todo']) && $_POST['todo']=="logout") {
	setcookie("feed","",time()-3600);
	header ("Location:http://www.cbdealer.com/cb_feed.php");
	exit;
}
	
/************** GET LOGIN ************************/
if (isset($_COOKIE['feed'])) { // see if this user is already logged in
	$query="select id,expire_date from feed_users where id='".$_COOKIE['feed']."'";
} elseif (isset($_REQUEST['email']) && isset($_REQUEST['pw'])) { // get the login info
	$query="select id,expire_date from feed_users where email='".$_REQUEST['email']."' and password='".$_REQUEST['pw']."'";
}
if (!isset($query)) {
	header ("Location:http://www.cbdealer.com/cb_feed.php");
	exit;
} else {
	require (SRVROOT.'cr/dbconn.php');
}
if (mysql_num_rows($result)!=1) {
	header("Location:http://www.cbdealer.php/cb_feed.php");
	exit;
} else {
	$user_data=mysql_fetch_assoc($result);
	$expire=strtotime($user_data['expire_date']);
	$today=strtotime(date("Y-m-d"));
	if ($expire<$today) {
	header("Location:http://www.cbdealer.php/cb_feed.php");
	exit;
	}
}


/*************** GET REMAINING DOWNLOADS *****************/
$files=array("tab","pipe","mysql");
$now=date("Y-m-d H:i:s");
foreach ($files as $file) {
	$varname=$file."_rem";
	$disabled=$file."_dis";
	$query="select * from feed_dls where id='".$user_data['id']."' and file='cb_$file.zip' and date_time>date_sub(now(), interval 1 day)";
	require (SRVROOT.'cr/dbconn.php');
	$count=mysql_num_rows($result);
	$$varname=2-$count;
	$$varname<1?$$disabled=" disabled":$$disabled=""; // sets button status for the form
	
}
/********************************************************/

/************* GET FILE INFO *********************/
$tab="/home/cbdlr/catalog/cb_tab.zip";
$pipe="/home/cbdlr/catalog/cb_pipe.zip";
$mysql="/home/cbdlr/catalog/cb_mysql.zip";

$pipeupdate=date("M j, Y g:ia O",filemtime($pipe));
$pipesize=round(filesize($pipe)/1024000,2);

$tabupdate=date("M j, Y g:ia O",filemtime($tab));
$tabsize=round(filesize($tab)/1024000,2);

$mysqlupdate=date("M j, Y g:ia O",filemtime($mysql));
$mysqlsize=round(filesize($mysql)/1024000,2);
/**************************************************/

include (DOCROOT."includes/header.inc.php");

?>
<h1>ClickBank<sub>&reg;</sub> MarketPlace Datafeed Download</h1>
<b>Direct downloads</b><br />
You can directly download these files by inserting your login information and the filename into a URL. This is handy for automating the download in applications.<br />
URL format for direct downloads:<br />
<b>http://www.cbdealer.com/cb_dl.php?uid=<i>your login email address</i>&pw=<i>your password</i>&file=<i>filename</i></b><br /> where <i>filename</i> is one of cb_tab.zip, cb_pipe.zip, or cb_mysql.zip
<p /><p />

<table cellpadding="10" cellspacing="0" border="0" width="100%">
<tr class="topnav" style="font-size:12px;font-weight:bold">
	<td align="center">File type<sup>&nbsp;</sup></td>
	<td align="center">Last update<sup>&nbsp;</sup></td>
	<td align="center">Size<sup>1</sup></td>
	<td align="center">Downloads remaining<sup>2</sup></td>
	<td align="center">Download</td>
</tr>
<tr style="background-color:#cbecff">
	<td><b>Pipe-delimited text</b></td>
	<td><?=$pipeupdate?></td>
	<td><?=$pipesize?>M</td>
	<td align="center"><?=$pipe_rem?></td>
	<td align="center">
	<form action="/cb_dl.php" target="dl_wdo" method="post">
	<input type="hidden" name="file" value="cb_pipe.zip" />
	<input type="submit" class="man_b" style="width:100px" value="cb_pipe.zip"<?=$pipe_dis?> />
	</form>
	</td>
	
</tr>
<tr>
	<td><b>Tab-delimited text</b></td>
	<td><?=$tabupdate?></td>
	<td><?=$tabsize?>M</td>
	<td align="center"><?=$tab_rem?></td>
	<td align="center">
	<form action="/cb_dl.php" target="dl_wdo" method="post">
	<input type="hidden" name="file" value="cb_tab.zip" />
	<input type="submit" class="man_b" style="width:100px" value="cb_tab.zip"<?=$tab_dis?> />
	</form>
	</td>
	
</tr>
<tr style="background-color:#cbecff">
	<td><b>MySQL table</b></td>
	<td><?=$mysqlupdate?></td>
	<td><?=$mysqlsize?>M</td>
	<td align="center"><?=$mysql_rem?></td>
	<td align="center">
	<form action="/cb_dl.php" target="dl_wdo" method="post">
	<input type="hidden" name="file" value="cb_mysql.zip" />
	<input type="submit" class="man_b" style="width:100px" value="cb_mysql.zip"<?=$mysql_dis?> />
	</form>
	</td>
	
</tr>
</table>
<br />
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="todo" value="logout" />
<div align="center">
<input type="submit" class="man_b" value="LOGOUT" />
</div>
</form>
<p />
<span style="font-size:10px">
<sup>1</sup> Filesizes are expected to be between 3M and 4M. Deviation from this range may indicate a problem with file integrity. <span style="color:#990000"><b>Always verify the inegrity of these files before using them.</b></span> We strongly suggest that you retain the previous day'<!--'-->s files for rollback purposes.
</span>
<p />
<span style="font-size:10px">
<sup>2</sup>You are limited to two downloads of each file in any 24 hour period. If you experience download problems, please contact <a href="http://www.s1m.com/support.html">Source 1 Media support</a>.
</span>

<iframe name="dl_wdo" width="0" height="0" frameborder="0" scrollbars="0"></iframe>
<?php

include (DOCROOT."includes/footer.inc.php");

?>

