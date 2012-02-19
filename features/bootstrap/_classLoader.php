<?php
require_once 'mink/autoload.php';

function ptbfAutoLoader ($name) {
	if (preg_match('/^\\\\?Ptbf/', $name)) {
		$name = ltrim($name, '\\');
		$name = preg_replace('/\\\\/', DIRECTORY_SEPARATOR, $name);
		
		echo PHP_EOL . 'loading: ' . $name . PHP_EOL;
		
		require __DIR__ . '/_lib/' . $name . '.php';
	}
}

spl_autoload_register('ptbfAutoLoader');

