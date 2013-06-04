<?php

Route::set('webcli', 'webcli')
	->defaults(array(
		'directory'  => 'webcli',
		'controller' => 'index',
		'action'     => 'run',
	));

?>