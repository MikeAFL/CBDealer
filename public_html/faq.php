<?php

require("config.php");
include (DOCROOT."includes/header.inc.php");

?>

<script type="text/javascript">

function getAnswer(item){
	// close the item if it's already open
	if (document.getElementById(item).innerHTML!='') {
		document.getElementById(item).innerHTML='';
		return;
	}
	
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!"); // change this to redirect to the non-js page
				return false;
			}
		}
	}
	// Receives data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			 document.getElementById(item).innerHTML=ajaxRequest.responseText+'<p />';
		}
	}
	ajaxRequest.open("GET", "faq_answer.php?id="+item, true);
	ajaxRequest.send(null); 

}

</script>
<h2>Frequently Asked Questions</h2>
<noscript>
<div align="center">
<span style="font-weight:bold;color:#990000">Please enable JavaScript to view FAQ answers.</span>
</div>
</noscript>
<?php
/**** get the categories ****/
$query="select id,name from faq_cat order by display_order";
require (SRVROOT.'cr/dbconn.php');
$cats=array();
while (list($id,$name)=mysql_fetch_array($result)) {
	array_push($cats,array('id'=>$id,'name'=>$name));
}


/***** build the questions *****/
foreach ($cats as $cat) {
	echo "<p /><span class=\"faq_cat\">&nbsp;&nbsp;".$cat['name']."&nbsp;&nbsp;</span><p />
	<div></div>";
	$query="select id,question from faq_item where cat='".$cat['id']."' order by display_order";
	require (SRVROOT.'cr/dbconn.php');
	$items=array();
	while (list($id,$question)=mysql_fetch_array($result)) {
		array_push($items,array('id'=>$id,'question'=>$question));
	}
	foreach ($items as $item) {
		echo "<a href=\"javascript:getAnswer('".$item['id']."')\" class=\"question\">".$item['question']."</a>
		<div id=\"".$item['id']."\" class=\"answer\"></div><br />";
	}
}




include (DOCROOT."includes/footer.inc.php");

?>
