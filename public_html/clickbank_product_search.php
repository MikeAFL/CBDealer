<?php
require("config.php");
include (DOCROOT."includes/header.inc.php");

?>

<?php

if (isset($_POST["todo"]) && $_POST["todo"]=="search") {
	$fields=array("keywords","category","gravity","eps","pps","rp","comm");
	$check=0;
	foreach ($fields as $field) {
		$_POST[$field]===""?$check=$check:$check++;
	}
	if ($check==0) {
		echo "
		<script type=\"text/javascript\">
		alert ('No search criteria entered');
		</script>
		";
	} else {
		$query="select distinct id,title,description from cb_products where ";
		if (isset($_POST['keywords']) && $_POST['keywords']!=="") {
			$_POST['match']=="any"?$join="or":$join="and";
			$keys=explode("'",$_POST['keywords']);
			
	}
}
?>


<script type="text/javascript" src="/includes/ajax.js"></script>

<script type="text/javascript">
function getSubs() {
	cats=document.search.category.selectedIndex;
	cats=document.search.category[cats].value;
	if (cats=="") {
		return;
	} else {
		item="subCategory";
		url="/php_inc/get_search_subs.php?cat="+escape(cats);
		ajaxCall(item,url);
	}
}

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
	

<h1>ClickBank Product Search</h1>
<form name="search" action="<?=$_SERVER["PHP_SELF"]?>" method="post">
<input type="hidden" name="todo" value="search" />

<table cellpadding="5" cellspacing="0" border="0" align="center">
<tr>
	<td align="right" colspan="2">
	<b>Search for keywords or phrases:</b><br />
	<span class="small"><i>Separate multiple keywords with commas</i>
	</td>
	<td colspan="2">
	<input type="text" name="keywords" class="man_w" size="40" value="<?=$_POST["keywords"]?>" />
	</td>
</tr>
<tr>
	<td align="right">Match </td>
	<td>
	<select name="match" class="man_w">
	<?php
	$any="";$all="";
	if (isset($_POST["match"])) {
		switch ($_POST["match"]) {
			case "any":
			$any=" selected=\"selected\"";
			$all="";
			break;
			case "all":
			$any="";
			$all=" selected=\"selected\"";
		}
	}
	?>
		<option value="any"<?=$any?>>Any</option>
		<option value="all"<?=$all?>>All</option>
	</select>
	 keywords
	 </td>
	 <td>
	 <?php
	 $tf_title="";$tf_desc=""; $tf_both=" checked";
	 if (isset($_POST["textfield"])) {
		 switch ($_POST["textfield"]) {
			 case "title":
			 $tf_title=" checked=checked";
			 $tf_desc="";
			 $tf_both="";
			 break;
			 case "description":
			 $tf_title="";
			 $tf_desc=" checked=checked";
			 $tf_both="";
			 break;
			 default:
			 $tf_title="";
			 $tf_desc="";
			 $tf_both=" checked=checked";
		 }
	 }
	 ?>

	 Search in <input type="radio" name="textfield" value="title"<?=$tf_title?> />title <input type="radio" name="textfield" value="description"<?=$tf_desc?> />description <input type="radio" name="textfield" value="both"<?=$tf_both?> />both
	 </td>
</tr>
</table>

<table cellpadding="5" cellspacing="0" border="0" align="center">
<tr>
	<td>


<?php
$query="select distinct category from cb_products";
require (SRVROOT."cr/dbconn.php");
$cats=array();
while (list($cat)=mysql_fetch_array($result)) {
	array_push($cats,$cat);
}
?>

<table cellpadding="5" cellspacing="0" border="0" align="center">
<tr>
	<td align="right">
	<b>Category: </b>
	</td>
	<td>
	<select class="man_w" name="category" onchange="getSubs()">
	<option></option>
	<?php
	foreach ($cats as $cat) {
		if (isset($_POST["category"]) && $cat==$_POST["category"]) {
			$selected=" selected=\"selected\"";
		} else {
			$selected="";
		}
		echo "<option value=\"$cat\"$selected>$cat</option>\n";
	}
	?>
	</select>
	</td>
	<td align="right">
	<b>Subcategory: </b>
	</td>
	<td>
	<select class="man_w" name="subCategory" id="subCategory"></select>
	</td>
	
</tr>
</table>

<table cellpadding="5" cellspacing="0" border="0" align="center">
<tr>
	<td align="right"><b>Gravity:</b>
	<select class="man_w" name="rel_grav">
	<?php
	$more=" selected=\"selected\"";$less="";
	if (isset($_POST["rel_grav"])) {
		switch ($_POST["rel_grav"]) {
			case "less":
			$less=" selected=\"selected\"";
			$more="";
			default:
			$less="";
			$more=" selected=\"selected\"";
		}
	}
	?>
	<option value="more"<?=$more?>>more than</option>
	<option value="less"<?=$less?>>less than</option>
	</select> <input type="text" class="man_w" name="gravity" size="8" value="<?=$_POST["gravity"]?>" />
	</td>
	
	<td align="right"><b>Earned/Sale:</b>
	<select class="man_w" name="rel_eps">
	<?php
	$more=" selected=\"selected\"";$less="";
	if (isset($_POST["rel_eps"])) {
		switch ($_POST["rel_eps"]) {
			case "less":
			$less=" selected=\"selected\"";
			$more="";
			default:
			$less="";
			$more=" selected=\"selected\"";
		}
	}
	?>
	<option value="more"<?=$more?>>more than</option>
	<option value="less"<?=$less?>>less than</option>
	</select> <input type="text" class="man_w" name="eps" size="8" value="<?=$_POST["eps"]?>" />
	</td>
</tr>
<tr>
	<td align="right"><b>Percent/Sale:</b>
	<select class="man_w" name="rel_pps">
	<?php
	$more=" selected=\"selected\"";$less="";
	if (isset($_POST["rel_pps"])) {
		switch ($_POST["rel_pps"]) {
			case "less":
			$less=" selected=\"selected\"";
			$more="";
			default:
			$less="";
			$more=" selected=\"selected\"";
		}
	}
	?>
	<option value="more"<?=$more?>>more than</option>
	<option value="less"<?=$less?>>less than</option>
	</select> <input type="text" class="man_w" name="pps" size="8" value="<?=$_POST["pps"]?>" />
	</td>
	
	<td align="right"><b>Referred Percentage:</b>
	<select class="man_w" name="rel_rp">
	<?php
	$more=" selected=\"selected\"";$less="";
	if (isset($_POST["rel_rp"])) {
		switch ($_POST["rel_rp"]) {
			case "less":
			$less=" selected=\"selected\"";
			$more="";
			default:
			$less="";
			$more=" selected=\"selected\"";
		}
	}
	?>
	<option value="more"<?=$more?>>more than</option>
	<option value="less"<?=$less?>>less than</option>
	</select> <input type="text" class="man_w" name="rp" size="8" value="<?=$_POST["rp"]?>" />
	</td>
</tr>
<tr>
	<td align="right"><b>Commision:</b>
	<select class="man_w" name="rel_comm">
	<?php
	$more=" selected=\"selected\"";$less="";
	if (isset($_POST["rel_comm"])) {
		switch ($_POST["rel_comm"]) {
			case "less":
			$less=" selected=\"selected\"";
			$more="";
			default:
			$less="";
			$more=" selected=\"selected\"";
		}
	}
	?>
	<option value="more"<?=$more?>>more than</option>
	<option value="less"<?=$less?>>less than</option>
	</select> <input type="text" class="man_w" name="comm" size="8" value="<?=$_POST["comm"]?>" />
	</td>
	<td align="center">
	<input type="submit" class="man_b" value="Search Products" />
</tr>
</table>

</form>
		
<script type="text/javascript">
getSubs();
</script>

<?php

include (DOCROOT."includes/footer.inc.php");

?>

