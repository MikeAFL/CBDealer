<?php
$pagetitle="ClickBank Marketplace Statistics";
require("config.php");
include (DOCROOT."includes/header.inc.php");

?>
<?php
virtual ("/includes/stats_nav.inc");
?>
<?php
//include ("cb_update.inc");
?>
<h1>ClickBank<sub>&reg;</sub> MarketPlace Statistics</h1>

<h2>What's hot and what's not in the ClickBank MarketPlace</h2>
<b>Popularity Rank</b> is a good indication of what products are converting in the ClickBank Marketplace. <b>Big Movers</b> and <b>Big Losers</b> show you which products had the biggest gains and which products had the biggest losses in Popularity Rank.
<p />
<div align="center">
Go to: <a href="/clickbank_stats_gainers.php"><b>Big Movers</b></a>&nbsp;&nbsp;&nbsp;&nbsp;Go to: <a href="/clickbank_stats_losers.php"><b>Big Losers</b></a>
</div>
<p />
<b>Gravity</b> is another good indicator of the overall recent success of ClickBank Affiliates in promoting a product. This is how ClickBank defines gravity:<br />
<table cellpadding="4" cellspacing="0" border="0" width="50%" align="center" style="font-size:10px;background-color:#daf4ff">
<tr>
	<td>
	Number of distinct affiliates who earned a commission by referring a paying customer to the publisher'<!--'-->s products. This is a <i>weighted sum</i> and not an actual total. For each affiliate paid in the last 8 weeks we add an amount between 0.1 and 1.0 to the total. The more recent the last referral, the higher the value added.
	</td>
</tr>
</table>
<p />
<div align="center">
Go to: <a href="/clickbank_stats_gravity.php"><b>Gravity-Referred Percentage</b></a>
</div>

<h2>What'<!--'-->s new in the ClickBank Marketplace</h2>
Get details on new products added to the ClickBank Marketplace since our last update.
<p />
<div align="center">
Go to: <a href="/clickbank_new_products.php"><b>New Products</b></a>
</div>

<h2>What'<!--'-->s been dropped from the ClickBank Marketplace</h2>
Get details on products dropped from the ClickBank Marketplace since our last update.
<p />
<div align="center">
Go to: <a href="/clickbank_dropped_products.php"><b>Dropped Products</b></a>
</div>


<?php

include (DOCROOT."includes/footer.inc.php");

?>

