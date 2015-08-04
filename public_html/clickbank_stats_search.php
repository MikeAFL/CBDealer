<?php
require("config.php");
include (DOCROOT."includes/header.inc.php");

?>
<?php
/*** set up the category and subcategory array ***/
$query="select distinct subcategory,category from stats_poprank order by category";
require (SRVROOT.'cr/dbconn.php');
$cats=array();
while (list($subcat,$cat)=mysql_fetch_array($result)) {
	array_push($cats,array('cat'=>$cat,'subcat'=>$subcat));
}

?>

	<td align="center">
	<b>Search for stats by ID or category</b><br />
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<b>ID:</b> <span style="font-size:9px">(Partial OK)</span> <input type="text" name="id" class="man_b" size="12" value="<?=$_POST['id']?>"
	<br /><i>-OR-</i><br />
	<b>Category:</b><br />
	<select name="category" class="man_w">
	<option value=""></option>
	<?php
	foreach ($cats as $cat) {
		echo "<option value=\"".$cat['cat']."|".$cat['subcat']."\">".$cat['cat']."|".$cat['subcat']."</option>\n";
	}
	?>
	</select>
	<br />
	<input type="submit" class="man_b" value="SEARCH" />
	</td>
</tr>
</table>




<?php

include (DOCROOT."includes/footer.inc.php");

?>

