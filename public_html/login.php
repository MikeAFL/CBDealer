<?php

if (isset($store_login)) {
	?>
	<a href="/store_stats.php" class="small"><b>STORE STATS</b></a>
	&nbsp;&nbsp;&nbsp;
	<a href="/ad_stats.php" class="small"><b>AD STATS</b></a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Logged in as <?=$user_data['aff_link']?>&nbsp;
	<form action="/getlogout.php" method="post" style="display:inline">
	<input type="hidden" name="page" value="http://<?=$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>" />
	<input type="submit" value="Logout" class="login" />
	</form>
<?php
} else {
	?>
	
	<script type="text/javascript">
	function popWin(url,popW,popH) {
		//if (document.all || document.layers) {
		   w = screen.availWidth;
		   h = screen.availHeight;
		//}

		//var popW = 300, popH = 200;

		var leftPos = (w-popW)/2, topPos = (h-popH)/2;

		window.open(url,'popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos);
	}
	</script>

	
	LOGIN: 
	<form name="topLogin" action="/getlogin.php" method="post" style="display:inline">
	<input type="hidden" name="page" value="http://<?=$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>" />
	User ID:<input type="text" name="user" class="login" size="12" /> Password:<input type="password" name="password" class="login" size="12" /> <input type="submit" value="Login" class="login" />
	</form>
	&nbsp;&nbsp;&nbsp;
	<a href="#" class="small" onclick="popWin('/gtrstpw.php','400','180')"><b>FORGOT PASSWORD?</b></a>
	<?php
}

?>
