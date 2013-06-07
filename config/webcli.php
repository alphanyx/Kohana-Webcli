<?php

return array(
	'allowedIPs' => array(
		'127.1.0.1' // lokal
	),
	'loginType' => 'shell', // shell or auth
	'logins' => array(
		'demo' => 'fe01ce2a7fbac8fafaed7c982a04e229', // pw: demo
		'root' => '63a9f0ea7bb98050796b649e85481845', // pw: root
	),
	'template' => '',
	'onlySSL' => false,
	'JavaScript' => array(
		'//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', // jQuery
		'//cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js', // jqMousewheel
		// 'js/jquery.terminal.js', // jqTerminal
	),
	'CSS' => array(
		'//terminal.jcubic.pl/css/jquery.terminal.css',
	),
);
