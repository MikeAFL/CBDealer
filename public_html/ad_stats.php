<?php
require ("config.php");

include (DOCROOT."includes/header.inc.php");

$query="select 1=1";
require (SRVROOT."cr/dbconn.php");

/*** check for login - show quick stats if they are logged in ***/
if (isset($_COOKIE['cblogin'])) {
	$user=mysql_real_escape_string($_COOKIE['cblogin']);
	
	/*** limit to date range if we have dates posted ***/
	if (isset($_POST['start']) || isset($_POST['end'])) {
		$start=explode("/",$_POST['start']);
		$end=explode("/",$_POST['end']);
		if (count($start)==3) {
			$start=$start[2]."-".$start[0]."-".$start[1]." 00:00:00";
		} else {
			unset($start);
		}
		if (count($end)==3) {
			$end=$end[2]."-".$end[0]."-".$end[1]." 23:59:59";
		} else {
			unset ($end);
		}
		if (isset($start) && isset($end)) {
			$daterange=" and (date>='$start' and date<='$end')";
		} elseif (isset($start)) {
			$daterange=" and date>='$start'";
		} elseif (isset($end)) {
			$daterange=" and date<='$end'";
		} else {
			$daterange="";
		}
	}

	/*** get quick stats for ads ***/
	$query="select count(*),count(distinct user_ip) from ad_views where block in (select id from ads where user_nick='$user')$daterange";
	require (SRVROOT."cr/dbconn.php");
	$views=mysql_fetch_row($result);
	$query="select count(*),count(distinct user_ip) from ad_clicks where block in (select id from ads where user_nick='$user'$daterange)";
	require (SRVROOT."cr/dbconn.php");
	$clicks=mysql_fetch_row($result);
	
	/*** get extended stats ***/
	$query="select id from ads where user_nick='$user'";
	require (SRVROOT."cr/dbconn.php");
	$adblocks=array();
	while (list($getblock)=mysql_fetch_array($result)) {
		array_push($adblocks,array('block'=>$getblock));
	}
	
}

if (!isset($user)) {
	echo "<img src=\"/images/spacer.gif\" width=\"1\" height=\"240\" align=\"right\" />
	<div align=\"center\">Please log in to view your stats</div>
	";
} else {

?>

<link rel="stylesheet" type="text/css" href="/includes/datepicker.css" />
<script type="text/javascript" src="/includes/datepicker.js"></script>
<script type="text/javascript">
function clearDates() {
	document.byDate.start.value='';
	document.byDate.end.value='';
}
</script>
<h1>Ad Stats for <?=$user?></h1>


<b>View by date</b>&nbsp;&nbsp;
<form name="byDate" action="<?=$_SERVER['PHP_SELF']?>" method="post" style="display:inline">
<input type="image" src="/images/cal.gif" width="16" height="16" onclick="displayDatePicker('start');return false;" /> From:
<input type="text" name="start" readonly="readonly" class="man_w" style="border:none" value="<?=$_POST['start']?>" />
<input type="image" src="/images/cal.gif" width="16" height="16" onclick="displayDatePicker('end');return false;" /> To:
<input type="text" name="end" readonly="readonly" class="man_w" style="border:none" value="<?=$_POST['end']?>" />
<input type="submit" class="man_b" value="UPDATE" />
<input type="button" class="man_b" value="CLEAR DATES" onclick="clearDates()" />

</form>

<table cellpadding="6" cellspacing="0" border="0" width="100%">
<tr>
	<td colspan="4">
	<b>Total Views</b> Raw:<?=$views[0]?> Unique:<?=$views[1]?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Clicks</b> Raw:<?=$clicks[0]?> Unique:<?=$clicks[1]?>
	</td>
</tr>
<tr class="hi_hdr">
	<td>Source URL</td>
	<td align="center">Raw views</td>
	<td align="center">Unique user<br />views</td>
	<td align="center">Clickthroughs</td>
</tr>
<?php
/*** set up alternating row colors ***/
$color[0]=" style=\"background-color:#daf4ff\"";
$color[1]=" style=\"background-color:#ffffff\"";
$rowcount=0;


foreach ($adblocks as $adblock) {
	echo "<tr><td colspan=\"4\"><b>BLOCK ID #".$adblock['block']."</b></td></tr>";
	$query="select url,count(user_ip),count(distinct user_ip) from ad_views where block='".$adblock['block']."'$daterange group by url";
	require (SRVROOT."cr/dbconn.php");
	$views=array();
	while (list($url,$raw,$unique)=mysql_fetch_array($result)) {
		array_push($views,array('url'=>$url,'raw'=>$raw,'unique'=>$unique));
	}
	foreach ($views as $view) {
		$query="select count(user_ip) from ad_clicks where block='".$adblock['block']."'$daterange";
		require (SRVROOT."cr/dbconn.php");
		$clicks=mysql_fetch_row($result);
		$rowcolor=$rowcount%2;
		$view['url']===''?$url="Unknown":$url=$view['url'];
		?>
		<tr<?=$color[$rowcolor]?>>
		<td><?=$url?></td>
		<td align="center"><?=$view['raw']?></td>
		<td align="center"><?=$view['unique']?></td>
		<td align="center"><?=$clicks[0]?></td>
		</tr>
		<?php
		$rowcount++;
	}
	echo "<tr><td colspan=\"4\"><hr /></td></tr>";
}
?>
</table>

<?php
}

include (DOCROOT."includes/footer.inc.php");

?>
