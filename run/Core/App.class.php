<?php
/**
 * 控制器调用方法
 */
class App{
	static function run(){
		if(is_file(CONFIG_PATH.'config.php'))
			C(require CONFIG_PATH.'config.php');
		//从地址栏获取类名、方法名
		$c=isset($_GET['c'])?$_GET['c']:'Index';
		$m=isset($_GET['m'])?$_GET['m']:'index';
		//定义类名常量、方法名常量
		define('CONTROLLER',ucfirst($c).'Controller');
		define('METHOD',$m);
		$controller=CONTROLLER;
		//实例化类
		$obj=new $controller;
		//判断方法是否存在
		if(!method_exists($obj, $m)){
			die(':( 您请求的方法不存在');
		}
		$obj->$m();
	}
}