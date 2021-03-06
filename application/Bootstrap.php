<?php

/**
 * @name Bootstrap
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends \Yaf\Bootstrap_Abstract
{
	private $config;

	public function _initErrors ()
	{
		// 如果为开发环境，则打开所有错误提示
		if(\Yaf\ENVIRON === 'develop') {
			error_reporting(E_ALL); // 设置错误日志级别
			init_set('display_errors', 1);
			init_set('display_startup_errors', 1);
		}
	}

	/**
	 * 加载　vendor　下的文件
	 */
	public function _initLoader ()
	{
		\Yaf\Loader::import(APP_PATH . '/vendor/autoload.php');
	}

	/**
	 * 配置初始化
	 */
	public function _initConfig ()
	{
		// 把配置保存起来
		$this->config = \Yaf\Application::app()->getConfig();
		\Yaf\Registry::set('config', $this->config);
	}

	/**
	 * 日志
	 * @param \Yaf\Dispatcher $dispatcher
	 */
	public function _initLogger (\Yaf\Dispatcher $dispatcher)
	{
		// SocketLog
		if(\Yaf\ENVIRON === 'develop') {
			if($this->config->socketlog->enable) {
				// 载入
				\Yaf\Loader::import('Common/Logger/slog.function.php');
				// 配置SocketLog
				slog($this->config->socketlog->toArray(), 'config');
			}
		}
	}

	/**
	 * 插件
	 * @param \Yaf\Dispatcher $dispatcher
	 */
	public function _initPlugin (\Yaf\Dispatcher $dispatcher)
	{
		// 注入一个插件
		// $objSamplePlugin = new SamplePlugin();
		// $dispatcher->registerPlugin($objSamplePlugin);
	}

	/**
	 * 路由
	 *　@param \Yaf\Dispatcher $dispatcher
	 */
	public function _initRoute (\Yaf\Dispatcher $dispatcher)
	{
	 	// 在这里注册自己的路由协议，默认使用简单路由
	}

	/**
	 * LocalName
	 */
	public function _initLocalName ()
	{
		//
	}

	/**
	 * View
	 * @param \Yaf\Dispatcher $dispatcher
	 */
	public function _initView (\Yaf\Dispatcher $dispatcher)
	{
		$view_engine = $this->config->application->view->engine;
		if ($view_engine == 'twig') { // 使用 twig 做模板引擎
			$twig = new \Twig\Adapter(APP_PATH . '/application/views/', $this->config->get("twig")->toArray());
			$dispatcher->setView($twig);
		} elseif ($view_engine == 'smarty') { // 使用 smarty 做模板引擎
			$smarty = new \Smarty\Adapter(null, $this->config->smarty->toArray());
			$dispatcher->setView($smarty);
		}
	}

	/**
	 * 初始化数据库分发器
	 * @function _initDefaultDbAdapter
	 * @author jsyzchenchen@gmail.com
	 */
	public function _initDefaultDbAdapter ()
	{
		// 初始化 illuminate\database
		$capsule = new \Illuminate\Database\Capsule\Manager;
		$capsule->addConnection($this->config->database->toArray());
		$capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
		$capsule->setAsGlobal();
		//　开启Eloquent ORM
		$capsule->bootEloquent();

		class_alias('\Illuminate\Database\Capsule\Manager', 'DB');
	}

	/**
	 * 公用函数载入
	 */
	public function _initFunction ()
	{
		\Yaf\Loader::import('Common/functions.php');
	}
}
