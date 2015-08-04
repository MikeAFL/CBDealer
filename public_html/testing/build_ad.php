<?php
require "../config.php";

/**** initialize the db connection for mysql_real_escape_string ****/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

if (!isset($_COOKIE['cblogin'])) {
	header("Location:http://".$_SERVER['SERVER_NAME']);
} else {
	$nick=mysql_real_escape_string($_COOKIE['cblogin']);
}

include (DOCROOT."includes/header.inc.php");

/*** for testing ***/


/**** see if we're saving an ad ****/
if (isset($_POST['todo']) && $_POST['todo']=="savenew") {
	$query="insert into ads (user_nick,linkcolor,target,keywords,keyword_join,num_ads) values ('$nick',";
	$values=array('lnkcolor','target','keywords','join','num_ads');
	$queryvals="";
	foreach ($values as $value) {
		$queryvals.="'".mysql_real_escape_string($_POST[$value])."',";
	}
	$queryvals=rtrim($queryvals,",");
	$query.=$queryvals.")";
	//echo $query;
	require (SRVROOT.'cr/dbconn.php');
	$ad_id=mysql_insert_id();
}

?>

<html>
<head>

<script type="text/javascript" src="/includes/ColorPicker2.js"></script>
<script type="text/javascript" src="/includes/ajax.js"></script>

<script type="text/javascript">

// We don't want to use our stylesheet for preview colors
// so set some defaults if there are no form values
function setDefaults() {
	fields=new Array('bdrcolor','bgcolor','txtcolor','lnkcolor');
	postFields=new Array("<?=$_POST['bdrcolor']?>","<?=$_POST['bgcolor']?>","<?=$_POST['txtcolor']?>","<?=$_POST['lnkcolor']?>");
	colors=new Array('#000099','#ffffff','#000000','#0000ff');
	for (i=0;i<fields.length;i++) {
		field=fields[i];
		if (!document.buildAd[field].value && postFields[i].length<1) {
			document.buildAd[field].value=colors[i];
		}
	}
}

function setKeyInput() {
	if (document.buildAd.metas.checked) {
		document.buildAd.keywords.disabled=true;
		document.buildAd.keychk.disabled=true;
	} else {
		document.buildAd.keywords.disabled=false;
		document.buildAd.keychk.disabled=false;
	}
}

function setPreview() {
	setDefaults();
	content='<table cellpadding="4" cellspacing="4" width="120px" ';
	content+='style="border:2px solid '+document.buildAd.bdrcolor.value+';';
	content+='background-color:'+document.buildAd.bgcolor.value+';';
	content+='color:'+document.buildAd.txtcolor.value+';';
	content+='font-family:sans-serif;font-size:9px;"><tr><td>';

	iter=document.buildAd.num_ads.selectedIndex;
	iter=document.buildAd.num_ads[iter].value;
	//count=Number(iter)+1;
	iter++;
	for (i=0;i<iter;i++) {
		content+='<a href="#" style="font-family:sans-serif;font-size:11;font-weight:bold;color:'+document.buildAd.lnkcolor.value+';">Product Title is a Clickable Link</a><br />';
		content+='This is some descriptive text for the product. It is taken from the product description in the database.';
		content+='<br /><br />';
	}

	content+='</td></tr></table>';

	document.getElementById("preview").innerHTML=content;

}
	
function checkForm() {
	// check for keywords
	if (!document.buildAd.metas.checked && !document.buildAd.keywords.value) {
		if (!confirm('You have not entered any keywords and\nyou haven\'t elected to use keywords from your page.\nClick \'Ok\' generate an untargeted ad.\nClick \'Cancel\' to enter a keyword selection.')) {
			document.buildAd.keywords.focus();
			return;
		}
	}
	document.buildAd.submit();
}

function hiLiteCode(box) {
	document.codebox.code.select();
}

function chkKeys() {
	ajaxCall('chk_keys','/testing/chk_keys.php?keywords='+document.buildAd.keywords.value+'&join='+document.buildAd.join.value);
}

cp = new ColorPicker('window'); 
cpbdr = new ColorPicker(); // border color
cpbg = new ColorPicker(); // background color
cplnk = new ColorPicker(); // link color
cptxt = new ColorPicker(); // text color

cp.writeDiv()

</script>

</head>

<body>
<noscript>
<div align="center">
<span class="error">
This form requires JavaScript
</span>
</div>
</noscript>

<form name="buildAd" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<input type="hidden" name="todo" value="savenew" /> 
<table cellpadding="6" cellspacing="0" border="0" width="100%">
<tr>
	<td width="120px" style="padding:0px" align="center">
	<b>Ad Preview</b>
	<p />
	<div id="preview" style="position:relative"></div>
	</td>
	<td valign="top">
	
	<table cellpadding="6" cellspacing="0" border="0" width="100%">
	<tr>
		<td colspan="4">
		<?php
		if (isset($ad_id)) {
			?>
			Your ad block has been created. The ad ID# is <?=$ad_id?>. Record this ID# to make it easier to find your ad for editing in the future. (The ad edit module is a planned enhancement for the next release of CB Dealer AdSends). Scroll to the bottom of this page to copy the ad block code. Paste the code into any page at the location where you want to display the ad block.
			<?php
		} else {
			?>
			Use this form to create your ad block. You can see how your ad block will look by clicking the 'UPDATE PREVIEW' button below. Once you are satisfied with your ad block, click the 'SAVE &AMP; GENERATE' button. This will write your ad settings to the database and generate code that you can copy and paste into your web page. Your generated code will appear at the bottom of this page.
			<?php
		}
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<span class="hi_hdr">&nbsp;&nbsp;Target Window&nbsp;&nbsp;</span><p />
		Select a target window for links in this ad block. 'Same window' will cause ad clicks to open in the current window. Selecting 'New window' will cause a new browser window to open when a user clicks your ad.
		</td>
		<td align="right" width="25%"><b>Target Window:</b> </td>
		<td>
		<select name="target">
		<?php
		$trgt1="";$trgt2="";
		if (isset($_POST['target'])) {
			switch ($_POST['target']) {
				case "_blank":
				$trgt1=" selected=\"selected\"";$trgt2="";
				break;
				case "_top":
				$trgt1="";$trgt2=" selected=\"selected\"";
				break;
				default:
				$trgt1="";$trgt2="";
			}
		}
		?>
			<option value="_blank"<?=$trgt1?>>New window</option>
			<option value="_top"<?=$trgt2?>>Same window</option>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"><span class="hi_hdr">&nbsp;&nbsp;Block Size&nbsp;&nbsp;</span><p />
		Select the number of ads to show in this block. Select from 2 to 5 ads. Remember that there will be one ad for CB Dealer in your block in addition to your selection.
		</td>
		<td align="right"><b>Number of ads:</b> </td>
		<td>
		<select name="num_ads" onchange="setPreview()">
		<?php
		isset($_POST['num_ads'])?$num_ads=$_POST['num_ads']:$num_ads=3;
		for ($x=2;$x<=5;$x++) {
			$num_ads==$x?$selected=" selected=\"selected\"":$selected="";
			echo "<option value=\"$x\"$selected>$x</option>\n";
		}
		?>
		</select>
		</td>
	</tr>
			
	<tr>
		<td colspan="4"><span class="hi_hdr">&nbsp;&nbsp;Keywords&nbsp;&nbsp;</span><p />
		Enter up to three keywords or phrases, separated by commas. Keywords should only contain alphanumeric characters.
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<b>Keywords:</b> <input type="text" name="keywords" size="60" class="man_w" value="<?=$_POST['keywords']?>" />
		</td>
	</tr>
	<tr>
		<td colspan="4"
		<div align="center">
		<b>--<i> OR </i>--</b>
		</div>
		<br />
		Check the box below to use the first three keywords in your page keyword metatag. <i>You must have a properly formatted keyword metatag in your page for this to work.</i><br />
		Ex: &lt;meta name="keywords" content="clickbank, easy profits, free storefront" /&gt;
		<br />
		<span class="small"><b>Note:</b> You cannot check the number of keyword matches when using this option.</span>
		<p />
		<?php
		isset($_POST['metas'])?$checked=" checked=\"checked\"":$checked="";
		?>
		<input type="checkbox" name="metas" class="man_w"<?=$checked?> onclick="javascript:setKeyInput()" /> <b>Use keywords from my page</b>
		<p />
		<?php
		$match1="";$match2="";
		if (isset($_POST['join'])) {
			switch ($_POST['join']) {
				case "all":
				$match1=" selected=\"selected\"";$match2="";
				break;
				case "any":
				$match1="";$match2=" selected=\"selected\"";
				break;
				default:
				$match1="";$match2="";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		Select whether product ads should match all of your keywords or any keyword. 'All' will result in more relevant, but fewer matches. 'Any' will match more products. Check the number of matching products below. If you get too few matches using 'All', try changing your selection to 'Any'.
		<td colspan="2" align="center">
		<b>Match <select name="join">
			<option value="and"<?=$match1?>>all</option>
			<option value="or"<?=$match2?>>any</option>
		</select> keywords</b>
		<p />
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<b>Check the number of unique products that match your keywords</b>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="button" class="man_b" name="keychk" value="CHECK KEYWORD MATCHES" onclick="chkKeys()" />
		</td>
		<td colspan="2">
		<div id="chk_keys"></div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<span class="hi_hdr">&nbsp;&nbsp;Colors&nbsp;&nbsp;</span>
		</td>
	</tr>
	<tr>
		<td align="right"><b>Border:</b> </td>
		<td>
		<input type="text" name="bdrcolor" size="10" class="man_w" value="<?=$_POST['bdrcolor']?>" onchange="setPreview()" /><br />
		<a href="#" onclick="cpbdr.select(document.buildAd.bdrcolor,'bdr');return false;" name="bdr" id="bdr"><span class="small"><b>COLOR PICKER</b></span></a>
		</td>
		<td align="right"><b>Background:</b> </td>
		<td><input type="text" name="bgcolor" size="10" class="man_w" value="<?=$_POST['bgcolor']?>" /><br />
		<a href="#" onclick="cpbg.select(document.buildAd.bgcolor,'bg');return false;" name="bg" id="bg"><span class="small"><b>COLOR PICKER</b></span></a>
		</td>
	</tr>
	<tr>
		<td align="right"><b>Links:</b> </td>
		<td><input type="text" name="lnkcolor" size="10" class="man_w" value="<?=$_POST['lnkcolor']?>"><br />
		<a href="#" onclick="cplnk.select(document.buildAd.lnkcolor,'lnk');return false;" name="lnk" id="lnk"><span class="small"><b>COLOR PICKER</b></span></a>
		</td>
		<td align="right"><b>Text:</b> </td>
		<td><input type="text" name="txtcolor" size="10" class="man_w" value="<?=$_POST['txtcolor']?>"><br />
		<a href="#" onclick="cptxt.select(document.buildAd.txtcolor,'txt');return false;" name="txt" id="txt"><span class="small"><b>COLOR PICKER</b></span></a>
		</td>
	</tr>
	</table>
	
	
	
	
	</td>
</tr>
</table>
<div align="center">
<input type="button" class="man_b" value="UPDATE PREVIEW" onclick="setPreview();" />
&nbsp;&nbsp;&nbsp;
<input type="button" class="man_b" value="SAVE &amp; GENERATE" onclick="checkForm()" />
</div>
</form>

<table cellpadding="4" cellspacing="0" border="0" width="80%" align="center" style="border:2px solid #094d94;">
<tr>
	<td>
	<?php
	if (isset($_POST['todo']) && $_POST['todo']=="savenew") {
		isset($_POST['metas'])?$keys="&k='+keys+'":$keys="";
		$bgcolor=mysql_real_escape_string($_POST['bgcolor']);
		$txtcolor=mysql_real_escape_string($_POST['txtcolor']);
		$bdrcolor=mysql_real_escape_string($_POST['bdrcolor']);

		$ad_code="<!-- BEGIN CBDEALER CODE -->
<script type=\"text/javascript\" src=\"http://www.cbdealer.com/includes/cbadsrv.js\"></script>
<script type=\"text/javascript\">
today=new Date();";
if (isset($_POST['metas'])) {
	$ad_code.="getKeys();";
}
$ad_code.="fetch('$ad_id');
</script>
<div id=\"$ad_id\" name=\"$ad_id\" style=\"width:120px;background-color:$bgcolor;color:$txtcolor;border:2px solid $bdrcolor;padding:4px;margin:4px;float:left\"></div>
<!-- END CBDEALER CODE -->";
		
		echo "
		<form name=\"codebox\">
		<div align=\"center\">
		<b>Copy and paste this code at the location on your page where you want to display your ad block<p />
		Ad ID# $ad_id</b><p />
		<input type=\"button\" class=\"man_b\" value=\"HIGHLIGHT CODE\" onclick=\"hiLiteCode()\">
		</div>
		<textarea name=\"code\" rows=\"10\" cols=\"80\">".htmlentities($ad_code)."</textarea>
		</form>
		";
		
	} else {
		echo "<div align=\"center\">Your ad code will appear here.</div>";
	}
	?>
	</td>
</tr>
</table>

<script type="text/javascript">
setPreview();
</script>

<?php

include (DOCROOT."includes/footer.inc.php");


?>
