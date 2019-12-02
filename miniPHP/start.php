<?php
if(!defined('APP_NAME')) die('APP_NAME NO DEFINED!');
class Mini{
	public static function run(){
		//1.设置常量
		self::_set_const();
		//2.创建文件夹
		self::_create_dir();
		//3.载入框架必须文件
		self::_load_file();
		//4.执行应用类的run
		application::run();
	}
	private static function _set_const(){
		define('APP_PATH',  ROOT_PATH. '/app/');
		//定义框架根路径
		define('MINI_PATH',ROOT_PATH.'/miniPHP');
		//定义扩展路径
		define('EXTEND_PATH', ROOT_PATH . '/Extend');
		//定义扩展里面的工具路径
		define('LIB_PATH', MINI_PATH . '/library');
		//定义框架Config路径
		define('CONFIG_PATH', ROOT_PATH . '/config');
		//定义框架Core路径
		define('CORE_PATH', LIB_PATH . '/core');
		//定义框架Function路径
		define('FUNCTION_PATH', LIB_PATH . '/function');
		//定义应用的配置路径
		define('APP_CONFIG_PATH', APP_PATH .APP_NAME. '/config');
		//定义应用的模板路径
		define('APP_TPL_PATH', APP_PATH .APP_NAME. '/templete');
		define('APP_PUBLIC_PATH', APP_TPL_PATH . '/public');
		//定义应用的控制路径
		define('APP_CONTROL_PATH', APP_PATH .APP_NAME. '/controller');
		define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
		define('IS_AJAX',isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ? true : false);
	}

	/**
	 * [_create_dir 创建应用文件夹]
	 * @return [type] [description]
	 */
	private static function _create_dir(){
		$dirArr = array(
			APP_CONFIG_PATH,
			APP_TPL_PATH,
			APP_PUBLIC_PATH,
			APP_CONTROL_PATH
			);
		foreach ($dirArr as $v) {
			is_dir($v) || mkdir($v,0777,true);
		}
	}

	/**
	 * [_load_file 加载框架必须文件]
	 * @return [type] [description]
	 */
	private static function _load_file(){
		require_once(FUNCTION_PATH . '/function.php');
		require_once(CORE_PATH . '/application.php');
	}

}
Mini::run();
