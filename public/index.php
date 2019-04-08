<?php
header('content-type:text/html;charset=utf-8');

define('APP_PATH', realpath(dirname(__FILE__) . '/../')); // APP_PATH 即为 yaf 目录本身
$app = new Yaf\Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
?>
