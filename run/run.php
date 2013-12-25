<?php
/**
 * runner框架
 */
final class Run{
	static function init(){
		//定义常量
		self::define_const();
		//引入核心文件
		self::require_core();
		//初始化应用目录
		self::init_dir();
		//初始化控制器
		self::init_controller();
		//初始配置文件
		self::init_config();
		//运行控制器
		App::run();
	}
	/**
	 * 定义常量
	 */
	static function define_const(){
		//框架目录
		define('RUN_PATH',dirname(__FILE__).'/');

	}
	/**
	 * 引入框架核心文件
	 */
	static function require_core(){
		require(RUN_PATH.'Core/App.class.php');
		require(RUN_PATH.'Core/function.php');
	}
	/**
	 * 初始化项目目录
	 */
	static function init_dir(){
		//控制器目录
		define('CONTROLLER_PATH',APP_PATH.'Controller/');
		//模板目录
		define('TEMPLATE_PATH',APP_PATH.'Template/');
		//配置文件目录
		define('CONFIG_PATH',APP_PATH.'Config/');
		//创建目录
		foreach (array(APP_PATH,CONTROLLER_PATH,TEMPLATE_PATH,CONFIG_PATH) as $f) {
			is_dir($f) || mkdir($f,0775);
		}
	}
	/**
	 * 创建默认控制器
	 */
	static function init_controller(){
		$file=CONTROLLER_PATH.'IndexController.class.php';
		if(is_file($file))return;
		$data=<<<str
<?php
class IndexController extends Controller{
	public function index(){
		header('Content-type:text/html;charset=utf8');
		echo '<h1>欢迎使用run框架</h1>';
	}
}
str;
		file_put_contents($file, $data);
	}
	/**
	 * 初始化配置文件
	 */
	static function init_config(){
		$file=CONFIG_PATH.'config.php';
		if(is_file($file))return;
		$data=<<<str
<?php
return array(
	'DB_HOST'=>'localhost',
	'DB_USER'=>'root',
	'DB_PASSWD'=>'',
	'DB_NAME'=>''
	);
str;
		file_put_contents($file, $data);
	}
}
Run::init();