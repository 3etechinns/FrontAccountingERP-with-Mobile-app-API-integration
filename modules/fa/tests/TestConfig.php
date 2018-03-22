<?php

ini_set('xdebug.show_exception_trace', 0);

if (file_exists(__DIR__ . '/../frontaccounting')) {
	$rootPath = realpath(__DIR__ . '/../frontaccounting');
} else {
	$rootPath = realpath(__DIR__ . '/../../..');
}

$apiPath = $rootPath . '/modules/fa';
define('ROOT_PATH', $rootPath);
define('SRC_PATH', $rootPath);
define('API_PATH', $apiPath);
define('TEST_PATH', $apiPath . '/tests');

