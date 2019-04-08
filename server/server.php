<?php

class HttpServer
{
	public static $instance;

	public $http;

	public static $get;
	public static $post;
	public static $header;
	public static $server;

	private $application;

	public function __construct () {
		$http = new swoole_http_server("127.0.0.1", 9501);
		$http->set([
			'worker_num' => 16,
			'daemonize' => true,
			'max_request' => 10000,
			'dispatch_mode' => 1
		]);
		$http->on('WorkerStart', [$this, 'onWorkerStart']);
		$http->on('request', function ($request, $response) {
			if(isset($request->server)) {
				HttpServer::$server = $request->server;
			} else {
				HttpServer:;$server = [];
			}
			if(isset($request->header)) {
				HttpServer::$header = $request->header;
			} else {
				HttpServer:;$header = [];
			}
			if(isset($request->get)) {
				HttpServer::$get = $request->get;
			} else {
				HttpServer:;$get = [];
			}
			if(isset($request->post)) {
				HttpServer::$post = $request->post;
			} else {
				HttpServer:;$post = [];
			}

			ob_start();
			try {
				$yaf_request = new Yaf\Request_Http(HttpServer::$server['request_uri']);
				$this->application->getDispatcher()->dispatch($yaf_request);
			} catch(Yaf_Exception $e) {
				var_dump($e);
			}

			$result = ob_get_contents();

			ob_end_clean();

			$response->end($result);
		});

		$http->start();
	}

	public function onWorkerStart () {
		define('APP_PATH', dirname(__DIR__));
		$this->application = new Yaf\Application(APP_PATH . '/conf/cli.ini');
		ob_start();
		$this->application->bootstrap()->run();
		ob_end_clean();
	}

	public static function getInstance () {
		if(!self::$instance) {
			self::$instance = new HttpServer;
		}
		return self::$instance;
	}
}

HttpServer::getInstance();
