<?php

$pagetitle="ClickBank Ad Builder";
$description="Create Adsense-type ads for ClickBank's top selling products.";
$keywords="ClickBank,ad builder,ad generator,adsense,clickbank,top-sellers";

require("config.php");

/*** check for login - send them to the adbuilder if they are logged in ***/
if (isset($_COOKIE['cblogin'])) {
	header("Location:http://".$_SERVER['SERVER_NAME']."/cbsrv/build_ad.php");
	exit;
}

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

<h1>ClickBank Ad Builder</h1>
Why settle for pennies from Google Adsense ads when you can put contextual advertising on your page that pays real commissions? By placing a small piece of code on your webpage, you can <b>display ads for the highest-converting, top-selling ClickBank products</b> that are related to your page.

<table cellpadding="0" cellspacing="0" border="0" align="right" width="120">
<tr>
	<td style="padding:4px">
	<b>LIVE DEMO</b><br />
	<span class="small">The adblock below is being delivered by our adserver for the keywords 'google' and 'adsense'.</span>
	</td>
</tr>
<tr>
	<td>
	<!-- BEGIN CBDEALER CODE -->
	<script type="text/javascript" src="http://www.cbdealer.com/includes/cbadsrv.js"></script>
	<script type="text/javascript">
	today=new Date();fetch('1124240');
	</script>
	<div id="1124240" name="1124240" style="width:120px;background-color:#ffffff;color:#000000;border:2px solid #ffffff;padding:4px;margin:4px;float:left"></div>
	<!-- END CBDEALER CODE -->
	</td>
</tr>
</table>

<h2>Online wizard builds your ad code</h2>
Just go through the easy-to-use wizard to generate code to display a block of ads. Copy the code and paste it into your page. It'<!--'-->s just that easy!

<h2>Ads are keyword-based</h2>
Enter keywords when you fill out the wizard, or let our ad server pull products based on the keywords in your web page.


<h2>Advertise ClickBank'<!--'-->s top-selling products</h2>
Our software finds products that match your keywords, and pulls ads for the very best selling products from those matches.

<h2>Product database is updated daily</h2>
Our product database is updated daily, so you always have the best new products, and never waste space advertising dropped products.

<h2>Customize ad blocks to match your site</h2>
Our wizard let'<!--'-->s you fully customize the colors of your ad block to match your page. You decide how many ads you want to include in a block.

<h1>ClickBank Ad Builder is FREE!</h1>
That'<!--'-->s right! You can create as many ads as you want, and put them on as many pages as you want, <b>absolutely free!</b> One ad in your block will be for CBDealer. The rest will be for high-converting ClickBank products. Just register using the form below and within minutes you can be creating revenue generating ads for your site.
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
<input type="hidden" name="src" value="ab" />
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

