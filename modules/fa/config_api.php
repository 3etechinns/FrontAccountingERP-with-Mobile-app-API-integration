<?php

if (file_exists(__DIR__ . '/backoffice')) {
	$rootPath = realpath(__DIR__ . '/backoffice');
} else {
	$rootPath = realpath(__DIR__ . '/../..');
}

define('API_ROOT', $rootPath . '/modules/fa');
define('FA_ROOT', $rootPath);

