
/******** start keys.js ************/

keys=''; // this declaration is here so keys is defined even if there is no keywords metatag

function getKeys() {

	// extract the content of the keywords metatag
	metatags=document.getElementsByTagName("meta");

	
	
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

/******** end keys.js ************/




/******** start bigllc-xjr.js ************/

/* *********************************************************************** */
/* (c) 2006 Bridge Interactive Group LLC. All Rights Reserved              */
/*                                                                         */
/* Author:  Marc G. Smith <msmith_at_bigllc_dot.com>                       */      
/* Version: 1.0                                                            */      
/* *********************************************************************** */
    
var com = com ? com : {}
    com.bigllc  = com.bigllc ? com.bigllc : {};   
    com.bigllc.xjr  = com.bigllc.xjr ? com.bigllc.xjr : {};

/* *********************************************************************** */

com.bigllc.xjr.CrossSiteJsonRequest = function()
{
    if(com.bigllc.xjr.CrossSiteJsonRequest.prototype.instance) {
      return com.bigllc.xjr.CrossSiteJsonRequest.prototype.instance;
    }
    
		var heads     = document.getElementsByTagName('head');
	  this.head     = heads[0];
	  this.busy     = false;
	  this.queue    = new Array();
	  this.timerId  = null; 
    this.timeOut	= 100;
    
	  var self = this;
	  this.queueDispatcher = function() {
	    if(!self.busy) {
	      var url = self.queue[0];
	      self.queue.splice(0, 1);
	      self.get(url);
	    }
	    
	    if(self.queue.length == 0) {
	      clearInterval(self.timerId);
	      self.timerId = null;
	    }
	  }
	  
	  com.bigllc.xjr.CrossSiteJsonRequest.prototype.instance = this;
}

/* *********************************************************************** */

com.bigllc.xjr.CrossSiteJsonRequest.prototype = {
  instance : null,
  
  setErrorHandler: function(handler) {
    this.errorHandler = handler;
  },

  setResponseHandler: function(handler) {
    this.responseHandler = handler;
  },
  
  get: function(url, timerId) {
    if(this.busy) {
      this.queue[this.queue.length] = url;
      
      if(!this.timerId) {
        this.timerId = setInterval(this.queueDispatcher, this.timeOut); 
      }
      
      return;
    }
    
    this.busy = true;
    
    url += (url.indexOf("?") < 0) ?  "?" : "&";
    url += "xjrid=" + new Date().getTime();
    
    if(this.scriptTag) { this.head.removeChild(this.scriptTag); }
		this.scriptTag=document.createElement('script');
		this.scriptTag.setAttribute('type','text/javascript');
		this.scriptTag.setAttribute('src', url);
		this.head.appendChild(this.scriptTag);
  },
  
  notify: function() {
		  try { xjrExecute(this.responseHandler); }
		  catch(e){ (this.errorHandler) ? this.errorHandler(e) : alert(e.message); }
		  this.busy = false;
		  //this.head.removeChild(this.scriptTag);
		  //this.scriptTag = null;
  } 
}

/* *********************************************************************** */

com.bigllc.xjr.RequestDispatcher = new com.bigllc.xjr.CrossSiteJsonRequest();

/* *********************************************************************** */

/******** end bigllc-xjr.js ************/

/******** start page script ************/

function XJRResponse(data) {
	var resp = document.getElementById(data.id);
	resp.innerHTML = data.html;
}

function fetch(block) {
	xjr.get("http://www.cbdealer.com/testing/rshi.php?a="+block+"&k="+keys+"&today");
}

var xjr = com.bigllc.xjr.RequestDispatcher;
xjr.setResponseHandler(XJRResponse);

/******** end page script ************/
