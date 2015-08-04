<?php
require("config.php");

$pagetitle="Free ClickBank Marketplace Affiliate Storefront";
$description="Free indexed and searchable ClickBank Marketplace Affiliate Storefront";
$keywords="ClickBank,storefront,cb mall,clickbank,ClickBank Marketplace Affiliate Storefront";

include (DOCROOT."includes/header.inc.php");

?>
<script type="text/javascript">
function checkForm() {
	if (!document.signup.cb_nick.value) {
		alert ('Please enter a ClickBank nickname');
		return;
	}
	if (!document.signup.email.value) {
		alert ('Please enter an email address');
		return;
	}
	if (!emailCheck(document.signup.email.value)) {
		alert (document.signup.email.value+' does not appear to be a valid email address');
		return;
	}
	if (!document.signup.password.value || document.signup.password.value!=document.signup.check_password.value) {
		alert ('No password entered or password entries don\'t match');
		return;
	}
	document.signup.submit();
}
</script>
	


<div align="center">
<h2>Congratulations! You are minutes away from having</h2>

<h1>You own FREE customizable and searchable<br />ClickBank<sub>&reg;</sub> MarketPlace Affiliate Storefront</h1>
</div>

Just fill out the brief form below, activate your account, and your own completely indexed and searchable ClickBank MarketPlace Storefront will instantly be live. <b>Completely FREE! Instant Setup!</b>


<h3>You can sell every ClickBank product</h3>
Your ClickBank Affiliate Storefront includes <b>every product in the ClickBank Marketplace!</b>

<h3>Completely indexed and searchable</h3>
Your ClickBank Affiliate Storefront includes <b>a complete up-to-date catalog index and a built-in product search engine</b>.

<h3>Customize the look of your store</h3>

Choose from over a dozen templates and add your own store name and tagline.

<h2>FREE!</h2>

<h3>No visible affiliate links!</h3>
Your affiliate product links are invisible to users. That means you can...

<h3>Place links to your storefront anywhere</h3>
Many directories and other websites will not accept affiliate links. Since your affiliate code is not visible anywhere in the URLs to your store, you can submit links to your store, product categories, and even individual products, to many of these free listing sites.

<!-- ------Start Cut Here----- -->
<a href="http://www.dailysofts.com/program/994/38154/ClickBank_Marketplace_Storefront.html" target="_blank">
<img border="0" src="http://www.dailysofts.com/images/5starsaward.gif" alt=" 5 Stars Award at dailysofts.com !" width="180" height="68" align="right" /></a>
<!-- ------End Cut Here----- -->

<h3>Your affiliate link is protected</h3>
Since users never see your affiliate link, they can'<!--'-->t strip out your referral code. <b>Stop link hijackers dead in their tracks!</b>

<h2>FREE!</h2>

Thousands of web-based businesses sell products and services through ClickBank affiliates. Now you can join ClickBank'<!--'-->s top earners. <b>No investment is required</b>. Just sign up below and you can activate your fully indexed and completely searchable ClickBank storefront instantly. We provide you with your own website, we host your site, and we update your ClickBank MarketPlace on a daily basis. In return, some of the clickthroughs will go to our ClickBank affiliate account. The split is determined by a sliding scale. The more unique user clickthroughs you have, the higher the percentage that goes directly to your affiliate account. Sure, you'<!--'-->re splitting some clicks with us, but <b>all of your clicks are free!</b>

<h3>What makes this a great deal?</h3>
<b>CB Dealer is completely free</b>. You get a website, and you don't need to worry about design, development, content, or hosting. We give you everything you need. Even if you already have a website or other methods to promote your ClickBank Affiliate sales, CB Dealer gives you another avenue to promote ClickBank products. You're sharing some of your traffic with us, but it's <b>free traffic you wouldn't have had otherwise</b>. Plus, the <b>cloaked affiliate links</b> mean you can place links in places that you couldn't before.<!--'--> This is the best kind of deal there is- a win/win for everybody!

<h3>All you need is a ClickBank affiliate account</h3>
If you don'<!--'-->t already have a ClickBank affiliate account, just <a href="http://hop.clickbank.net/?s1media/ezsignup" target="_blank">click here</a> to set one up. It's easy and it's free. Once you sign up, you'<!--'-->ll earn commisions on the thousands of products in your ClickBank MarketPlace Affiliate Storefront.

<h3>Conditions</h3>
The only condition to getting a free storefront is that you are forbidden to promote it by spamming. Since this is so important to us, we'<!--'-->ll repeat it: <b>You may not promote your CB Deals storefront by spamming</b>. If we catch you promoting your site by spamming (and we will catch you if you try it!), your storefront will be immediately deactivated and you will be permanently banned from CB Dealer.

<h3>Disclaimer</h3>
We guarantee that our technology will deliver between 50% and 80% of the clicks from your storefront with your ClickBank affiliate code, depending on your total unique clickthroughs. However, since we have no way of knowing which clicks will produce sales, and since commission amounts vary from product to product, we can'<!--'-->t guarantee that you will get exactly that percentage of the commisions generated. Over time, and a sufficient number of clicks, it should work out to approximately the correct split, but you may get slightly more or less than the exact percentage of the total commisions generated by your storefront.

<h2>SIGN UP NOW!</h2>
<noscript>
<div align="center">
<span style="color:red"><b>JavaScript must be enabled for this form to work. Please enable JavaScript and reload this page.</b></span>
</div>
<p />
</noscript>

<b>Just enter your ClickBank nickname and a valid email address to register your account. Your account will include access to the ClickBank Ad Builder and a free ClickBank Marketplace Storefront.</b>
<p />
<form action="/verify.php" name="signup" method="post">
<input type="hidden" name="src" value="sf" />
<table cellpadding="6" cellspacing="0" border="0" align="center">
<tr>
	<td align="right"><nobr><b>ClickBank Nickname</b></nobr></td>
	<td><input type="text" name="cb_nick" /></td>
	<td><a href="http://hop.clickbank.net/?s1media/ezsignup" target="_blank">Click here</a> to open your free ClickBank account if you don'<!--'-->t already have one.</td>
</tr>
<tr>
	<td align="right"><nobr><b>Email Address</b></nobr></td>
	<td><input type="text" name="email" /></td>
	<td>You must enter a valid email address to activate your account. We may occasionally send important information about updates or changes to CB Dealer to this address. We will never spam you, and we will never, ever share your email address with any third party.</td>
</tr>
<tr>
	<td align="right"><nobr><b>Password</b></nobr></td>
	<td><input type="password" name="password" /></td>
	<td rowspan="2">Please enter a password to access your CB Dealer account. <b>Do not enter the same password you use at ClickBank.com!</b></td>
</tr>
<tr>
	<td align="right"><nobr><b>Verify Password</b></nobr></td>
	<td><input type="password" name="check_password" /></td>
	
</tr>
<tr>
	<td colspan="3" align="center"><input class="man_b" type="button" onclick="checkForm()" value="SET UP MY ACCOUNT!" /></td>
</tr>
</table>
</form>

<?php

include (DOCROOT."includes/footer.inc.php");

?>

