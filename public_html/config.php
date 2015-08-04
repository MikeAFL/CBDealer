<?php

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

define ("SRVROOT","D:/cbdealer/site/");
define ("DOCROOT","D:/cbdealer/site/public_html/");

function showArray($array) {
	echo "<pre>";print_r($array);echo "</pre>";
}

function html2txt($document){
$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
               '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
);
$text = preg_replace($search, '', $document);
return $text;
}
?>