<?php

$year=date("Y");

if (!isset($pagetitle) || $pagetitle=="") {
	$pagetitle="ClickBank Dealer - home of the FREE ClickBank Affiliate Storefront";
}
if (!isset($description) || $description=="") {
	$description="Tools for the serious ClickBank Affiliate. Free ClickBank Marketplace Storefront, ClickBank stats, ClickBank Product Ad Builder, and more";
}
if (!isset($keywords) || $keywords=="") {
	$keywords="ClickBank,ClickBank Mall,free clickbank storefront,clickbank statistics,clickbank datafeed,clickbank calculators";
}

/**** check for store login ******/
if (isset($_COOKIE['cblogin'])) {
	$query="select site,aff_link,style,title,tagline from userdata where aff_link='".$_COOKIE['cblogin']."'";
	require (SRVROOT.'cr/dbconn.php');
	if (mysql_num_rows($result)==1) {
		$user_data=mysql_fetch_assoc($result);
		$store_login=true;
	}
}
/*****************************/

?>
<html>
<head>
<meta name="MSSmartTagsPreventParsing" content="TRUE">
<title><?=$pagetitle ?></title>
<meta name="description" content="<?=$description ?>" />
<meta name="keywords" content="<?=$keywords ?>" />
<meta name="revisit-after" content="10" />
<meta name="author" content="Source 1 Media">
<meta name="copyright" content="2005-<?=$year?> by Source 1 Media" />
<meta name="language" content="en-us">
<meta name="classification" content="Internet Services" />
<meta name="distribution" content="Global" />

<link rel="stylesheet" type="text/css" href="/includes/main.css" />
<script type="text/javascript" src="/includes/checkMail.js"></script>

</head>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="728" align="center">
<tr>
	<td class="topnav" align="right" valign="bottom" style="background-image:url(/images/header-2.jpg)">
	<img src="/images/spacer.gif" width="12" height="80" align="left" />
	</td>
</tr>
<tr>
	<td>
<?php
/*** set the item spacing for the nav rows ***/
$uspcr=" <img src=\"/images/spacer.gif\" width=\"18\" height=\"5\" />";
$lspcr=" <img src=\"/images/spacer.gif\" width=\"8\" height=\"5\" />";
?>
	<table class="topnav" cellpadding="3" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
		<?=$uspcr?>
		<a class="toplink" href="/index.php">HOME</a>
		<?=$uspcr?>
		<?php
		if (isset($store_login)) {
			?>
		<a class="toplink" href="/admin.php">STORE ADMIN</a>
		<?=$uspcr?>
		<a class="toplink" href="/cbsrv/build_ad.php">AD BUILDER</a>
			<?php
		} else {
			?>
			<a class="toplink" href="/clickbank_storefront.php">STOREFRONT</a>
		<?=$uspcr?>
		<a class="toplink" href="/clickbank_ad_builder.php">AD BUILDER</a>
			<?php
		}
		?>
		<?=$uspcr?>
		<a class="toplink" href="/cb_feed.php">DATAFEED</a>
		<?=$uspcr?>
		<a class="toplink" href="/clickbank_stats.php">STATS</a>
		<?=$uspcr?>
		<a class="toplink" href="/clickbank_calculator.php">CALCULATORS</a>
		<?=$uspcr?>
		<a class="toplink" href="/faq.php">FAQ</a>
		<!--?=$uspcr?>
		<a class="toplink" href="/forum/">FORUM</a-->
		</td>
	</tr>
	<tr>
		<td align="right" style="padding:3px;background-color:#ffffff;border:1px solid #14579e;color:#14579e;font-weight:bold;"><?php include (DOCROOT."login.php"); ?></td>
		<!--td align="right" class="topnav"><?php include (DOCROOT."login.php"); ?></td-->
	</tr>
	</table>
	</td>
</tr>
<tr>
<td width="100%" style="padding:8px">
<!-- BEGIN CONTENT -->

