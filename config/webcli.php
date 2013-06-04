<?php

return array(
	'allowedIPs' => array(
		'127.0.0.1' // lokal
	),
	'logins' => array(
		'demo' => 'demo',
		'root' => 'root',
	),
	'template' => '',
	'onlySSL' => false,
	'JavaScript' => array(
		'//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', // jQuery
		'//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js', // jqMousewheel
		'//terminal.jcubic.pl/js/jquery.terminal-0.6.3.min.js', // jqTerminal
	),
	'CSS' => array(
		'//terminal.jcubic.pl/css/jquery.terminal.css',
	),
);
