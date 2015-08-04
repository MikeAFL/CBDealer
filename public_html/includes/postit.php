<?php

function post_it($url)
{
//	$url = preg_replace("@^https://@i", "", $url);
	$url = preg_replace("@^http://@i", "", $url);
	$host = substr($url, 0, strpos($url, "/"));
	$uri = strstr($url, "/");
		
	$reqbody = ""; 
	foreach($_POST as $key=>$val) {
		if(is_array($val)) {  //don't url encode of array
			if (!empty($reqbody)) $reqbody .= "&";
			$reqbody .= $key . "=" . $val;
		}
		else {
			if (!empty($reqbody)) $reqbody .= "&";
			$reqbody .= $key . "=" . urlencode($val);
		}
	}

	$strlength = strlen($reqbody);
	$reqheader = "POST $uri HTTP/1.0\r\n".
	             "Host: $host\r\n" . "User-Agent: PostIt\r\n".
							 "Content-Type: application/x-www-form-urlencoded\r\n".
							 "Content-Length: $strlength\r\n\r\n".
							 "$reqbody\r\n";
//	header('Location: https://www.holeonegolf.com/submit.php');
	header('Location: http://www.cbdealer.dev/test.php');

	$socket = fsockopen("ssl://" . $host, 443, $errno, $errstr); 

	if (!$socket) {$result["errno"] = $errno; $result["errstr"] = $errstr; return $result;} 
	fputs($socket, $reqheader); 
	while (!feof($socket)) {$result[] = fgets($socket, 4096);} 
	fclose($socket);
	
	return $result; 
}

?>