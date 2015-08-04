<?php
$pagetitle="ClickBank Marketplace Statistics - Gravity";
require("config.php");
include (DOCROOT."includes/header.inc.php");

?>

<script type="text/javascript" src="/includes/ajax.js"></script>
<script type="text/javascript">
function getDetail(product) {
	// close the product if it's already open
	if (document.getElementById(product).innerHTML!='') {
		document.getElementById(product).innerHTML='';
		return;
	}
	url='show_detail.php?product='+escape(product);
	ajaxCall(product,url);
}
</script>
<?php
virtual ("/includes/stats_nav.inc");
?>

<div>
<h2 style="margin-top:-5px;">Gravity - Referred Percentage</h2>
<span style="position:relative; top:-10px;">
<b>ClickBank'<!--'-->s Top 20 Products in Gravity for this week.</b>
<br />
Click the ClickBank ID for a detailed report on any product.
<br />
</div>
	
<?php

$query="select id,grav_curr,grav_last,grav_diff,ref_curr,ref_last,ref_diff from stats_grav_ref where grav_last!='0' and ref_last!='0' order by grav_curr desc limit 20";
require (SRVROOT.'cr/dbconn.php');
$movers=array();
while (list($id,$grav_curr,$grav_last,$grav_diff,$ref_curr,$ref_last,$ref_diff)=mysql_fetch_array($result)) {
	array_push($movers,array('id'=>$id,'grav_curr'=>$grav_curr,'grav_last'=>$grav_last,'grav_diff'=>$grav_diff,'ref_curr'=>$ref_curr,'ref_last'=>$ref_last,'ref_diff'=>$ref_diff));
}

echo "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"90%\" align=\"center\">
<tr style=\"background-color:#094d94;color:#ffffff;font-weight:bold\">
<td></td>
<td align=\"center\" colspan=\"3\" style=\"background-color:#3a7ec5\">Gravity</td>
<td align=\"center\" colspan=\"3\">Referred Percentage</td>
</tr>
<tr style=\"background-color:#094d94;color:#ffffff;font-weight:bold\">
<td align=\"center\">ClickBank ID</td>
<td align=\"center\" style=\"background-color:#3a7ec5\">This Week</td>
<td align=\"center\" style=\"background-color:#3a7ec5\">Last Week</td>
<td align=\"center\" style=\"background-color:#3a7ec5\">Change</td>
<td align=\"center\">This Week</td>
<td align=\"center\">Last Week</td>
<td align=\"center\">Change</td>
</tr>
";
/*** set up alternating row colors ***/
$color[0]=" style=\"background-color:#daf4ff\"";
$color[1]=" style=\"background-color:#ffffff\"";
$rowcount=0;
$grav_sign="";
$ref_sign="";

foreach ($movers as $mover) {
	$rowcolor=$rowcount%2;
	$mover['grav_diff']>0?$grav_sign="+":$grav_sign="";
	$mover['ref_diff']>0?$ref_sign="+":$ref_sign="";
	echo "<tr".$color[$rowcolor].">
	<td>
	<a href=\"javascript:getDetail('".$mover['id']."')\">".$mover['id']."</a>
	</td>
	<td align=\"center\">".$mover['grav_curr']."</td>
	<td align=\"center\">".$mover['grav_last']."</td>
	<td align=\"center\">".$grav_sign.$mover['grav_diff']."</td>
	<td align=\"center\">".$mover['ref_curr']."</td>
	<td align=\"center\">".$mover['ref_last']."</td>
	<td align=\"center\">".$ref_sign.$mover['ref_diff']."</td>
	</tr>
	<tr><td colspan=\"7\">
	<div id=\"".$mover['id']."\"></div>
	</td>
	</tr>
	";
	$rowcount++;
}

?>
</table>
<?php

include (DOCROOT."includes/footer.inc.php");

?>

