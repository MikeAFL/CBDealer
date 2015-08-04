<?php
require("config.php");
$pagetitle="ClickBank Calculators for Vendors and Affiliates";
$description="Advanced calculators for ClickBank vendors and affiliates. Calculate commissions, prices, and more.";
include (DOCROOT."includes/header.inc.php");

?>
<script type="text/javascript" src="/includes/cb_calc.html"></script>

<h1>ClickBank Calculators</h1>
<noscript>
<div align="center">
<span class="error">JavaScript must be enabled to use these calculators</span>
</div>
</noscript>
<h2>ClickBank Affiliate Calculator</h2>
Calculate ClickBank commissions based on retail price
<p />

<!---- AFFILIATE CACULCATOR ---->
<form name="calcform">
<table cellpadding="6" cellspacing="0" border="0" align="center">
<tr>
	<td align="right"><b>Product price:</b> </td>
	<td><b>$</b><input size="6" name="aprice" class="man_b" /></td>
	<td align="right"><b>Commission:</b> </td>
	<td><input size="2" class="man_b" name="acomm"><b>%</b></td>
	<td><b>Affiliate Net: </b> </td>
	<td><input size="6" name="aaff" class="man_w" style="border:none" readonly="readonly"> </td>
</tr>
<tr>
	<td colspan="6" align="center"><input type="button" class="man_b" value="CALCULATE" onclick="calcComm()"></td>
</tr>
</table>
<h2>Advanced ClickBank Vendor Calculator</h2>
Given two parameters, this calculator will return sales information for any ClickBank transaction. Use it to set prices, calculate commissions, etc.<br />
<span class="small"><b>Examples:</b><br>
<b>Ex.1:</b> You have a product that you would like to net $25 on, and you want affiliates to get $20 per sale. To determine the necessary price and commission, select Vendor Net and enter 25, select Affiliate Net and enter 20, then calculate. The calculator will show that you need a price of $49.73 with the commission at approximately 44%.<br />
<b>Ex. 2:</b> Your product price is $39.95 and you want to clear $19 per sale. What should the commission be? Select Price and enter 39.95, select Vendor Net and enter 19, then calculate. The calculator will show that you can set the commission at 47%.<br />
<i><b>Note:</b> This calculator is subject to slight rounding errors on some calculations</i></span>
<p />

<!---- VENDOR CALCULATOR ---->
<table cellpadding="6" cellspacing="0" border="0" align="center">
<tr>
	<td>
		<select name="val1type" class="man_b">
			<option value="typePrice">Price</option>
			<option value="typeVNet">Vendor Net</option>
			<option value="typeANet">Affiliate Net</option>
			<option value="typeComm">Commision</option>
		</select>
		<input type="text" class="man_b" size="6" name="val1" value="<?=$_POST['val1']?>" />
	</td>
	<td>
		<select name="val2type" class="man_b">
			<option value="typePrice">Price</option>
			<option value="typeVNet">Vendor Net</option>
			<option value="typeANet">Affiliate Net</option>
			<option value="typeComm">Commision</option>
		</select>
		<input type="text" class="man_b" size="6" name="val2" value="<?=$_POST['val1']?>" />
	</td>
	<td>
</tr>
			
<tr>
	<td colspan="2" align="center">
	<input type="button" class="man_b" value="CALCULATE" onclick="vendCalc()" />
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
	<table cellpadding="6" cellspacing="0" border="0" align="center">
	<tr>
		<td align="right"><b>Price:</b> </td>
		<td><input type="text" name="showPrice" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	<tr>
		<td align="right"><b>ClickBank Commision:</b> </td>
		<td><input type="text" name="showVig" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	<tr>
		<td align="right"><b>Total Net:</b> </td>
		<td><input type="text" name="showTotnet" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	</table>
</td><td><img src="/images/spacer.gif" width="18" height="1" /></td><td>
	<table cellpadding="6" cellspacing="0" border="0" align="center">
	<tr>
		<td align="right"><b>Affiliate Commision:</b> </td>
		<td><input type="text" name="showComm" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	<tr>
		<td align="right"><b>Vendor Net:</b> </td>
		<td><input type="text" name="showVendnet" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	<tr>
		<td align="right"><b>Affiliate Net:</b> </td>
		<td><input type="text" name="showAffnet" class="man_w" style="border:none" size="6" readonly="readonly" /></td>
	</tr>
	</table>
</td></tr>
</table>
	
</form>

<?php

include (DOCROOT."includes/footer.inc.php");

?>
