<?php

print <<<SCRIPT

function xjrExecute(handler) {
	handler("The time is " + new Date());
}

com.bigllc.xjr.RequestDispatcher.notify();

alert("It worked");

SCRIPT;

?>