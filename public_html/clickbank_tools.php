<?php
require("config.php");

//showArray($_POST);

//$post=$_POST['category'];
//showArray($post);

$query="select distinct category from cb_products";
require (SRVROOT.'cr/dbconn.php');
$cats=array();
while (list($thecats)=mysql_fetch_array($result)) {
	array_push($cats,$thecats);
}

?>

<script type="text/javascript" src="/includes/ajax.js"></script>

<script type="text/javascript">

function getCats(item,url) {
	cats=document.categorySelect.category.selectedIndex;
	cats=document.categorySelect.category[cats].value;
	if (cats=='') {
		return;
	} else {
		item="subCategory";
		url="php_inc/get_subs.php?cat="+escape(cats);
		ajaxCall(item,url);
	}
}
</script>


<form name="categorySelect" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<select name="category" onchange="javascript:getCats()">
<option value=""></option>
<?php

foreach ($cats as $cat) {
	echo "<option value=\"$cat\">$cat</option>\n";
}

?>
</select>
&nbsp;
<select name="subCategory" id="subCategory">

</select>
<p />
<input type="submit">
</form>

