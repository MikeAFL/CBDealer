<?php
require "../config.php";

/*** get the parameters for this add ***/
/* only grab keywords if they're no in the get string */

isset($_GET['k'])?$keywords="":$keywords=",keywords";
$a=mysql_escape_string($_GET['a']); // this command is deprecated but it's faster since we don't have to establish a db connection before we use it
$query="select user_nick,linkcolor,target$keywords,keyword_join,num_ads from ads where id='$a'";
//echo $query;exit;
require (SRVROOT.'cr/dbconn.php');
if (mysql_num_rows($result)!=1) {
	/***
	
	just show a CB Dealer ad and bail
	
	***/
	exit;
} 

$ad_data=mysql_fetch_assoc($result);
/*** get the keywords ***/
switch ($keywords) {
	case "": // we had keywords in the query string
	$keywords=$_GET['k'];
	$splitter="|";
	break;
	case ",keywords": // we got keywords from the db record
	$keywords=$ad_data['keywords'];
	$splitter=",";
	break;
	default:
	$keywords=array(); // recast the $keywords var so we don't break later
	$splitter=",";
}

$keywords=explode($splitter,$keywords);
//showArray($keywords);

$keyquery="";
$keyword_join=$ad_data['keyword_join'];

foreach ($keywords as $keyword) {
	$keyword=mysql_real_escape_string($keyword);
	$keyword=trim($keyword);
	if (strlen($keyword)>0) {
		$keyquery.="(title like '%".trim($keyword)."%' or description like '%".trim($keyword)."%') $keyword_join ";
	}
}
/*** clean up the $keyquery ***/
if ($keyquery!="") {
	$keyquery=trim($keyquery);
	$keyquery=rtrim($keyquery,$keyword_join);
	$keyquery=" where ".$keyquery;
}


/*** get a random seed so we don't alway repeat the top ads ***/
$start=rand (1,20);
$num_ads=$ad_data['num_ads'];

$query="select distinct id,title,description from cb_products$keyquery order by gravity desc limit $start,$num_ads";
//echo $query;
//exit;
require (SRVROOT.'cr/dbconn.php');
$ads=array();
while (list($id,$title,$desc)=mysql_fetch_array($result)) {
	array_push($ads,array('id'=>$id,'title'=>$title,'desc'=>$desc));
}

$position=rand(0,$num_ads-1);
/*** make the second ad for CBDealer ***/
$ads[$position]['id']="cbdez1aler";
$ads[$position]['title']="CB Dealer";
$ads[$position]['desc']="Free tools for the serious ClickBank Affiliate<br />Stats, free storefont with search and link cloaking, ad generator and more.";

echo "<span style=\"font-size:9px;font-family:sans-serif\">\n";
foreach ($ads as $ad) {
	switch ($ad['id']) {
		case "cbdez1aler":
		$url="www.cbdealer.com";
		break;
		default:
		$url=$ad_data['user_nick'].".".$ad['id'].".hop.clickbank.net/";
	}
	echo "\n<a style=\"font-size:11px;color:#".$ad_data['linkcolor'].";font-family:sans-serif\" href=\"http://$url\" target=\"".$ad_data['target']."\"><b>".$ad['title']."</b></a><br />
	".$ad['desc']."<p />";
}
echo "\n</span>";

?>
