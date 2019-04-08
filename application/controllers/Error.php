<?php

/**
 * @name ErrorController
 * @desc 错误控制器，在发生未捕获的异常时被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 */
class ErrorController extends \Yaf\Controller_Abstract
{
	public function errorAction ($exception)
	{
		$this->getView()->assign('error_msg', $exception->getMessage());
	}
}
