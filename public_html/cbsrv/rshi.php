<?php
require "../config.php";

/*** initialize the db connection ***/
$query="select 1=1";
require (SRVROOT.'cr/dbconn.php');

/*** get the parameters for this add ***/
/* only grab keywords if they're not in the get string */

if (isset($_GET['k']) && $_GET['k']!=='') {
	$keywords="";
} else {
	$keywords=",keywords";
}
$a=mysql_real_escape_string($_GET['a']);
$query="select linkcolor,target$keywords,keyword_join,num_ads from ads where id='$a'";
$showq=$query;
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


/*** get a random seed so we don't alway repeat the top ads
we need the number of matches so we don't set the limit start too high ***/
$query="select count(distinct id) from cb_products$keyquery";
require (SRVROOT.'cr/dbconn.php');
$count=mysql_fetch_row($result);
$num_ads=$ad_data['num_ads'];
$count=$count[0]-$num_ads;
$count<0?$count=0:$count=$count;
$count>20?$count=20:$count=$count;
$start=rand (0,$count);


$query="select distinct id,title,description from cb_products$keyquery order by gravity desc limit $start,$num_ads";

require (SRVROOT.'cr/dbconn.php');
$ads=array();
while (list($id,$title,$desc)=mysql_fetch_array($result)) {
	array_push($ads,array('id'=>$id,'title'=>$title,'desc'=>$desc));
}

/**** insert the cbdealer ad into the array ****/
array_push($ads,array('id'=>"cbdez1aler",'title'=>"CB Dealer",'desc'=>"Free tools for the serious ClickBank Affiliate.<br />Stats, free storefont with search and link cloaking, this ad generator and more."));

shuffle($ads);

$output= "";
foreach ($ads as $ad) {
	switch ($ad['id']) {
		case "cbdez1aler":
		$url="www.cbdealer.com";
		break;
		default:
		/*** get a pk_id for this ad ***/
		$query="select pk_id from cb_products where id='".$ad['id']."' limit 1";
		require (SRVROOT.'cr/dbconn.php');
		$pk_id=mysql_fetch_row($result);
		$url="www.cbdealer.com/cbsrv.php?".$a."_".$pk_id[0];
	}
	$output.= "<span style=\"font-size:9px;font-family:sans-serif\"><a style=\"font-size:11px;color:".$ad_data['linkcolor'].";font-family:sans-serif\" href=\"http://$url\" target=\"".$ad_data['target']."\"><b>".$ad['title']."</b></a><br />".$ad['desc']."</span><p />";
}

$output=str_replace("'","\\'",$output); // don't let "'" mess up the javascript output

?>

function xjrExecute(handler) {
	var data = {
		id: "<?=$a?>",
		html: '<?=$output?>'
	};

	handler(data);
}

com.bigllc.xjr.RequestDispatcher.notify();

<?
/**** insert a record for this adview ****/
$query="insert into ad_views (block,user_ip,date,url) values ('$a','".$_SERVER['REMOTE_ADDR']."',now(),'".$_SERVER['HTTP_REFERER']."')";
require (SRVROOT.'cr/dbconn.php');
?>