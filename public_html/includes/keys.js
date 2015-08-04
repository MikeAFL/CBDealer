function getKeys() {

	// extract the content of the keywords metatag
	metatags=document.getElementsByTagName("meta");

	keys=''; // this declaration is here so keys is defined even if there is no keywords metatag
	
	if (typeof(metatags['keywords'])=='undefined') {
		return;
	}

	words=metatags['keywords'].getAttribute('content');

	tags=words.split(','); // create an array of keywords
	// put the first 3 keywords into a delimited string
	for (i=0;i<3 && i<tags.length;i++) {
		if (typeof(tags[i])!=undefined && tags[i].length>0) {
			keys+=tags[i]+'|';
		}
	}

	keys=escape(keys);
//	alert ('keywords are\n'+keys);
	
}
