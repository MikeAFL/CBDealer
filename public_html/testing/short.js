function xjrExecute(handler) {
	send='';
	for (x=0;x<5;x++) {
		//document.write('line'+x+'<p />');
		send+=='line'+x+'<p />';
	}
	handler(send);
}
com.bigllc.xjr.RequestDispatcher.notify();
