<?php
$pagetitle="ClickBank Marketplace New Products";
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

function closeProd(prodWin) {
	document.getElementById(prodWin).innerHTML='';
}
</script>

<?php
virtual ("/includes/stats_nav.inc");

$query="select count( distinct id) from cb_products_060108 where id not in (select id from cb_products)";
require (SRVROOT.'cr/dbconn.php');
$dropped=mysql_fetch_row($result);
$dropped=$dropped[0];

?>

<div>
<h2 style="margin-top:-5px;">Dropped ClickBank Products</h2>
<span style="position:relative; top:-10px;">
<b>ClickBank Marketplace products dropped since June 1, 2008.</b> (<?=$dropped?> products dropped)
<!--br />
<span style="font-size:9px"><i>Products appearing more than once are Big Movers in multiple categories</i></span-->
<br />
Click any ClickBank product for a detailed report.
<br />
</div>
	

<?php
$query="select distinct id,title,description from cb_products_060108 where id not in (select id from cb_products)";
require (SRVROOT.'cr/dbconn.php');
$movers=array();
while (list($id,$title,$description)=mysql_fetch_array($result)) {
	array_push($movers,array('id'=>$id,'title'=>$title,'description'=>$description));
}

echo "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"90%\" align=\"center\">
<tr>
";
/*** set up alternating cell colors ***/
$color[0]=" style=\"background-color:#daf4ff\"";
$color[1]=" style=\"background-color:#ffffff\"";
$cellcount=0;
$rowcount=0;
foreach ($movers as $mover) {
	$cellcolor=$cellcount%2;
	$thisdiv="div$cellcolor";
	$$thisdiv=$mover['id'];
	echo "
	<td".$color[$cellcolor]." width=\"50%\">
	<a href=\"javascript:getDetail('".$mover['id']."')\"><b>".$mover['title']."</b> (".$mover['id'].")</a><br />
	".$mover['description']."
	</td>
	";
	$cellcount++;
	$rowcount++;

	if ($rowcount>=2) {
		$cellcount--; // this alternates the cell color side to side
		$rowcount=0;
	echo "
	</tr>
	<tr><td colspan=\"2\">
	<div id=\"$div0\"></div><div id=\"$div1\"></div>
	</td></tr>
	<tr>
	";
	}
}

?>
</tr>
</table>
<?php

include (DOCROOT."includes/footer.inc.php");

?>

