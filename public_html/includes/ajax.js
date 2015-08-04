function ajaxCall(item,url){

	var ajaxRequest; 
	
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
			document.getElementById(item).innerHTML=ajaxRequest.responseText;
		}
	}
	ajaxRequest.open("GET", url, true);
	ajaxRequest.send(null); 

}
