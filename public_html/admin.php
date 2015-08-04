<?php
require("config.php");
//showArray($_POST);
/*** check for login ***/
if (!isset($_COOKIE['cblogin'])) {
	header("Location:http://".$_SERVER['SERVER_NAME']);
}
$query="select site from userdata where aff_link='".$_COOKIE['cblogin']."'";
require (SRVROOT.'cr/dbconn.php');
if (mysql_num_rows($result)!=1) {
	header("Location:http://".$_SERVER['SERVER_NAME']);
}

/*** Process form input ***/
if ($_POST['todo']=="update") {
	$updated=array("email","password","title","tagline","style");
	$query="update userdata set ";
	foreach ($updated as $update) {
		if ($_POST[$update]!='') {
			$query.="$update='".html2txt($_POST[$update])."',";
		}
	}
	$query=rtrim($query,",");
	$query.=" where aff_link='".$_COOKIE['cblogin']."'";
	require (SRVROOT.'cr/dbconn.php');
	$message="Information updated";
}

$query="select * from userdata where aff_link='".$_COOKIE['cblogin']."'";
require (SRVROOT.'cr/dbconn.php');
$data=mysql_fetch_array($result);
while (list($key,$value)=each($data)) {
	$$key=$value;
}

/*** get the new hit numbers ***/
$query="select count(*),count(distinct ip) from hops where site='$site'";
require (SRVROOT.'cr/dbconn.php');
$hits=mysql_fetch_row($result);
$raw_hits=$hits[0];$unique_hits=$hits[1];


$styles=array("arrows","bluestreak","classical","daisy","digital","meadow","money","raindrops","shimmer","sky1","sky2","skyline","skyscraper","solar","swoosh");
//echo $title;
include (DOCROOT."includes/header.inc.php");

?>
<script type="text/javascript">
function showpic(image) {
	window.open(image,'','width=760,height=500,dependent=true');
}

function checkForm() {
	if (document.editsite.password.value && (document.editsite.password.value!=document.editsite.confirmpass.value)) {
		alert('Passwords don\'t match');
		return;
	}
	if (!emailCheck(document.editsite.email.value)) {
		alert (document.editsite.email.value+' does not appear to be a valid email address');
		return;
	}
	document.editsite.submit();
}
	
</script>
<div align="center">
<b>&nbsp;<?=$message?>&nbsp;</b>
</div>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="editsite">
<input type="hidden" name="todo" value="update" />
<table cellpadding="6" cellspacing="0" border="0" align="center">
<tr>
	<td>
	<h2>Site Information</h2>
	<table cellpadding="5" cellspacing="0" style="border:1px blue solid" width="50%" align="right">
	<tr>
		<td align="center" colspan="2"><b>Change Password</b><br />
		Change password by entering a new password below.<br />Leave blank for no change.</td>
	</tr>
	<tr>
		<td align="right"><b>New password:</b> </td>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td align="right"><b>Confirm password:</b> </td>
		<td><input type="password" name="confirmpass" /></td>
	</tr>
	</table>
	<b>Store url:</b> <a href="http://www.cbdeals.com/<?=$site?>" target="_blank">http://www.cbdeals.com/<?=$site?></a><p />
	<b>Affiliate nickname:</b> <?=$aff_link?><p />
	<b>Email Address:</b> <input class="man_b" type="text" size="30" name="email" value="<?=$email?>" /><p />
	<b>Clickthroughs:</b> Total:<?=$raw_hits?>&nbsp;&nbsp;&nbsp;Unique users:<?=$unique_hits?>&nbsp;&nbsp;&nbsp;
	<a href="/store_stats.php"><b>Details</b></a>
	<p />
	<br clear="all" />

	<div align="center">
	<input type="button" class="man_b" value="Update" onclick="checkForm()" />
	</div>
	
	<hr />

	<h2>Site Setup</h2>
	<table cellpadding="4" cellspacing="0" border="0" align="center">
	<tr>
		<td align="right"><b>Title</b></td>
		<td><input class="man_b" type="text" size="40" name="title" value="<?=$title?>" /></td>
		<td align="right"><b>Tagline</b></td>
		<td><input class="man_b" type="text" size="40" name="tagline" value="<?=$tagline?>" /></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><b>Select a look for your site below. Click any thumbnail for a larger image.</b></td>
	</tr>
	</table>
	<table cellpadding="4" cellspacing="0" border="1">
	<tr>
	<?php
	foreach ($styles as $layout) {
		if ($cols>2) {
			echo "</tr>\n<tr>\n";
			$cols=0;
		}
		$layout==$style?$checked=" checked=\"checked\"":$checked="";
		$showstyle=ucwords($layout);
		?>
		<td>
		<input type="radio" name="style" value="<?=$layout?>"<?=$checked?> />
		<b><?=$showstyle?></b><br />
		<a href="javascript:showpic('/images/screenshots/ss_<?=$layout?>.jpg')"><img src="/images/screenshots/tss_<?=$layout?>.jpg" width="240" height="154" border="0" />
		</td>
		<?php

	$cols++;
	}
	?>
	</tr>
	</table>
	<div align="center">
	<p />
	<input type="button" class="man_b" value="Update" onclick="checkForm()" />
	</div>
	
	</td>
</tr>
</table>

</form>


<?php

include (DOCROOT."includes/footer.inc.php");

?>
