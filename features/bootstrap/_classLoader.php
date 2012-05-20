<?php

function ptbfAutoLoader ($name) {
	if (preg_match('/^\\\\?Ptbf\\\\/', $name)) {
		$name = ltrim($name, '\\');
		$name = preg_replace('/\\\\/', DIRECTORY_SEPARATOR, $name);
		
		echo PHP_EOL . 'loading: ' . $name . PHP_EOL;
		if (is_file( __DIR__ . '/_lib/' . $name . '.php')) {
			require __DIR__ . '/_lib/' . $name . '.php';
		}
	}
}

spl_autoload_register('ptbfAutoLoader');

