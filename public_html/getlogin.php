<?php

require("config.php");

/*** see if a page was passed from login.php ***/
if (!isset($_POST['page'])) {
	$url=$_SERVER['SERVER_NAME'];
} else {
	$url=$_POST['page'];
}
	
if (!isset($_POST['user']) || !isset($_POST['password'])) {
	header("Location:$url");
} else {
	/*** check the login ***/
	$query="select site from userdata where aff_link='".$_POST['user']."' and password='".$_POST['password']."'";
	require (SRVROOT.'cr/dbconn.php');
	if (mysql_num_rows($result)!=1) {
		header("Location:$url");
	} else {
		$user=mysql_fetch_assoc($result);
		setcookie("cblogin",$_POST['user']);
//		$url=$_SERVER['SERVER_NAME']."/admin.php";
		header("Location:$url");
	}
}
