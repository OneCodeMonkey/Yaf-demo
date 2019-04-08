<?php

/**
 * @name SamplePlugin
 * @desc Yaf定义了如下6个Hook,插件之间的执行顺序是先进先调用
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 */
class SamplePlugin extends Yaf_Plugin_Abstract
{
	public function routerStartup (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}

	public function routerShutdown (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}

	public function dispatchLoopStartup (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}

	public function preDispatch (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}

	public function postDispatch (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}

	public function dispatchLoopShutdown (Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
	{
		//
	}
}
