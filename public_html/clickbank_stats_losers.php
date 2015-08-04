<?php
$pagetitle="ClickBank Marketplace Statistics - Popularity Rank";
require("config.php");
include (DOCROOT."includes/header.inc.php");

?>

<script type="text/javascript" src="/includes/ajax.js"></script>
<script type="text/javascript">
function getDetail(product,category) {
	// close the product if it's already open
	if (document.getElementById(product).innerHTML!='') {
		document.getElementById(product).innerHTML='';
		return;
	}
	url='show_detail.php?product='+escape(product)+'&category='+escape(category);
	ajaxCall(product,url);
}
</script>
<?php
virtual ("/includes/stats_nav.inc");
?>

<div>
<h2 style="margin-top:-5px;">Big Losers</h2>
<span style="position:relative; top:-10px;">
<b>ClickBank'<!--'-->s Top 20 losers in Popularity Rank since June 1, 2008.</b>
<br />
<span style="font-size:9px"><i>Products appearing more than once are Big Losers in multiple categories</i></span>
<br />
Click the ClickBank ID for a detailed report on any product.
<br />
</div>
	

<?php
$query="select id,category,subcategory,rank_curr,rank_last,rank_diff from stats_poprank where subcategory<>'New Products' and rank_diff is not null order by rank_diff desc limit 20";
require (SRVROOT.'cr/dbconn.php');
$movers=array();
while (list($id,$category,$subcategory,$rank_curr,$rank_last,$rank_diff)=mysql_fetch_array($result)) {
	array_push($movers,array('id'=>$id,'category'=>$category,'subcategory'=>$subcategory,'rank_curr'=>$rank_curr,'rank_last'=>$rank_last,'rank_diff'=>$rank_diff));
}

echo "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"90%\" align=\"center\">
<tr style=\"background-color:#094d94;color:#ffffff;font-weight:bold\">
<td align=\"center\">ClickBank ID</td>
<td align=\"center\">Category</td>
<td align=\"center\">Subcategory</td>
<td align=\"center\">This Week</td>
<td align=\"center\">Last Week</td>
<td align=\"center\">Loss</td>
</tr>
";
/*** set up alternating row colors ***/
$color[0]=" style=\"background-color:#daf4ff\"";
$color[1]=" style=\"background-color:#ffffff\"";
$rowcount=0;

foreach ($movers as $mover) {
	$mover['subcategory']==""?$subcategory="<i>Top</i>":$subcategory=$mover['subcategory'];
	$rowcolor=$rowcount%2;
	echo "<tr".$color[$rowcolor].">
	<td>
	<a href=\"javascript:getDetail('".$mover['id']."[$rowcount]','".$mover['category']."|".$mover['subcategory']."')\">".$mover['id']."</a>
	</td>
	<td>".$mover['category']."</td>
	<td>".$subcategory."</td>
	<td align=\"center\">".$mover['rank_curr']."</td>
	<td align=\"center\">".$mover['rank_last']."</td>
	<td align=\"center\">-".$mover['rank_diff']."</td>
	</tr>
	<tr><td colspan=\"6\">
	<div id=\"".$mover['id']."[$rowcount]\"></div>
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

