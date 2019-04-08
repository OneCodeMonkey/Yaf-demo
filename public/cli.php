<?php
header('content-type:text/html;charset=utf-8');

define('APP_PATH', realpath(dirname(__FILE__) . '/../')); // APP_PATH 即　Yaf 目录本身

// 开启调试模式
define('APP_DEBUG', true);	// 切换到生产环境时，设为false

if (APP_DEBUG) {
	error_reporting(Ｅ_ALL); // 设置日志错误级别
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}

$application = new Yaf\Application(APP_PATH . '/conf/cli.ini');

$application->bootstrap()->run();
