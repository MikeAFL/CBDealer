<?php
/*** see if a page was passed from login.php ***/
if (!isset($_POST['page'])) {
	$url=$_SERVER['SERVER_NAME'];
} else {
	$url=$_POST['page'];
}


setcookie("cblogin","",time()-3600);
//$url=$_SERVER['SERVER_NAME'];
header("Location:$url");
?>