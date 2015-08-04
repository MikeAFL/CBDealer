<?php
require "config.php";

$product=$_GET['product'];

/**** get the product details ****/
if (isset($_GET['category'])) {
	$category=explode("|",$_GET['category']);
	$product=substr($product,0,strpos($product,"["));
	$query="select * from cb_products where id='$product' and category='".$category[0]."' and subcategory='".$category[1]."'";
} else {
	$query="select * from cb_products where id='$product' limit 1";
}
require (SRVROOT.'cr/dbconn.php');

$listing=mysql_fetch_assoc($result);

/**** get the product categories ****/
$query="select category,subcategory from cb_products where id='$product' order by category,subcategory";
require (SRVROOT.'cr/dbconn.php');
$cats="";
while (list($category,$subcategory)=mysql_fetch_array($result)) {
	$subcategory==""?$delim="":$delim="/";
	$cats.=$category.$delim.$subcategory."; ";
}

$cats=rtrim($cats,"; ");

?>


<table cellpadding="4" cellspacing="0" border="0" align="center" style="font-size:10px;border:1px solid;background-color:#ffffda">
<tr>
	<td colspan="8">
	<a href="http://www.cbdeals.com/1100/cbgo.php?prod=<?=$product?>" target="_blank"><b><?=$listing['title']?></b></a><br />
	<?=$listing['description']?>
	</td>
</tr>
<tr>
	<td align="right"><b>Popularity Rank:</b> </td>
	<td><?=$listing['popularityrank']?></td>
	<td>&nbsp;</td>
	<td align="right"><b>Gravity:</b> </td>
	<td><?=$listing['gravity']?></td>
	<td>&nbsp;</td>
	<td align="right"><b>Referred:</b> </td>
	<td><?=$listing['referred']?>%</td>
</tr>
<tr>
	<td align="right"><b>Earned/Sale:</b> </td>
	<td>$<?=$listing['earnedpersale']?></td>
	<td>&nbsp;</td>
	<td align="right"><b>Percent/Sale:</b> </td>
	<td><?=$listing['percentpersale']?>%</td>
	<td>&nbsp;</td>
	<td align="right"><b>Commision:</b> </td>
	<td><?=$listing['commision']?>%</td>
</tr>
<tr>
	<td colspan="8">
	<b>Currently listed in:</b><br />
	<?=$cats?>
	</td>
</tr>
<tr>
	<td colspan="8" align="center">
	<span style="font-size:9px">
	<a href="#" onclick="javascript: window.open('http://www.clickbank.com/info/ranking.html', 'hWin', 'height=700,width=500,resizable=yes,scrollbars=yes'); ">Click here</a> for an explanation of the terms in this report.
	</span>
	<br /><br />
	<a href="#" onclick="javascript:closeProd('<?=$product?>')"><b>Close</b></a>
	</td>
</tr>

</table>
