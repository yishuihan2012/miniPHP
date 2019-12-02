<?php

class application{

	public static function run(){
		// 1.初始化框架
		self::_init_frame();
		// 2.定义外部路径
		self::_set_url();
		// 3.自动载入
		spl_autoload_register(array(__CLASS__,'my_autoload'));
		// 4.创建demo(一个默认的控制器)
		self::_create_demo();
		// // 5.实例化控制器(输出 欢迎语)
		self::_app_run();
	}

	/**
	 * [_init_frame 初始化框架]
	 * @return [type] [description]
	 */
	private static function _init_frame(){
		//加载框架配置项
		// config(include CONFIG_PATH . '/config.php');
		//加载用户配置项
		//设置默认时区
		date_default_timezone_set(config('app.TIME_ZONE'));
		//开启session
		// C('SESSION_START') && session_start();

	}

	/**
	 * [_set_url 创建外部路径]
	 */
	private static function _set_url(){
		$module = isset($_GET['m']) ? htmlspecialchars($_GET['m']) : 'index';
		$action = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : 'index';
		$method = isset($_GET['c']) ? htmlspecialchars($_GET['c']) : 'index';
		//定义控制器常量
		define('MODULE', $module);
		define('ACTION', $action);
		define('METHOD', $method);

		define('__ROOT__', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
		define('__TPL__', dirname(__ROOT__) . '/' . APP_NAME . '/Tpl');
		define('__PUBLIC__', __TPL__ . '/Public');
		
		//当前地址
		define('__SELF__', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}

	/**
	 * [_autoload 自动载入]
	 * @param  [type] $className [description]
	 * @return [type]            [description]
	 */
	private static function my_autoload($className){
		//如果是控制器
		// echo $className;die;
		$className=str_replace("\\","/",$className);
		$path = ROOT_PATH . '/' . $className . '.php';
		// echo $path;die;
		if(!is_file($path)){
			var_dump('控制器：'. $path . '不存在');die;
		}
		// echo "<br/>";
		// echo $path;
		require_once($path);
		
	}


	private static function _create_demo(){
		$controlPath = APP_CONTROL_PATH . '/Index.php';
		if(!is_file($controlPath)){
			$data = <<<str
<?php
/**
 * 默认控制器，方法里面代码可以删除
 */
namespace app\index\controller;
class index {
	public function index(){
		header('Content-type:text/html;charset=utf-8');
		echo '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> miniPHP V1<br/><span style="font-size:30px">0载初心不改 - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
	}
}
str;
		file_put_contents($controlPath, $data) || die('access not allow');
		}

	}
	/**
	 * [_app_run 执行应用]
	 * @return [type] [description]
	 */
	private static function _app_run(){
		$model  = MODULE;
		$action = ACTION ;
		$method = METHOD;
		$str='app\\'.MODULE.'\controller\\'.ACTION;
		$obj=new $str;
		$obj->$method();
	}
}
?>