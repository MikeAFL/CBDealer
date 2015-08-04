<?php
require ("config.php");

include (DOCROOT."includes/header.inc.php");

$query="select 1=1";
require (SRVROOT."cr/dbconn.php");

/*** check for login - show quick stats if they are logged in ***/
if (isset($_COOKIE['cblogin'])) {
	$user=mysql_real_escape_string($_COOKIE['cblogin']);
	
	/*** get stats for the store ***/
	$query="select site from userdata where aff_link='$user'";
	require (SRVROOT."cr/dbconn.php");
	$site=mysql_fetch_row($result);
	$site=$site[0];
	
	/*** limit to date range if we have dates posted ***/
	if (isset($_POST['start']) || isset($_POST['end'])) {
		$start=explode("/",$_POST['start']);
		$end=explode("/",$_POST['end']);
		if (count($start)==3) {
			$start=$start[2]."-".$start[0]."-".$start[1];
		} else {
			unset($start);
		}
		if (count($end)==3) {
			$end=$end[2]."-".$end[0]."-".$end[1];
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
	
	
	/*** total counts ***/
	$query="select count(distinct vendor),count(*),count(distinct ip) from hops where site='$site'$daterange";
	require (SRVROOT."cr/dbconn.php");
	$raw_hits=mysql_fetch_row($result);
	
	/*** counts by vendor ***/
	$query="select p.title,h.vendor,count(h.ip),count(distinct h.ip) from cb_products p,hops h where site='$site'$daterange and p.id=h.vendor group by vendor";
	require (SRVROOT."cr/dbconn.php");
	$site_stats=array();
	while (list($title,$vendor,$raw,$unique)=mysql_fetch_array($result)) {
		array_push($site_stats,array('title'=>$title,'vendor'=>$vendor,'raw'=>$raw,'unique'=>$unique));
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
<h1>Stats for Store #<?=$site?></h1>


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
	<td colspan="3">
	<b><?=$raw_hits[1]?> clickthroughs on <?=$raw_hits[0]?> different products by <?=$raw_hits[2]?> unique users</b>
	</td>
</tr>
<tr class="hi_hdr">
	<td>Product</td>
	<td align="center">Raw clickthroughs</td>
	<td align="center">Unique user<br />clickthroughs
</tr>
<?php
/*** set up alternating row colors ***/
$color[0]=" style=\"background-color:#daf4ff\"";
$color[1]=" style=\"background-color:#ffffff\"";
$rowcount=0;


foreach ($site_stats as $site_stat) {
	$rowcolor=$rowcount%2;
	?>
<tr<?=$color[$rowcolor]?>>
	<td><?=$site_stat['title']?> (<?=$site_stat['vendor']?>)</td>
	<td align="center"><?=$site_stat['raw']?></td>
	<td align="center"><?=$site_stat['unique']?></td>
	
</tr>
<?php
	$rowcount++;
}
?>

</table>

<?php
}

include (DOCROOT."includes/footer.inc.php");

?>
