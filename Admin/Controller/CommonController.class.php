<?php
/**
 * 后台公共控制器
 */
class CommonController extends Controller{
	public function __construct(){
		//判断用户是否登录
		session_id() || session_start();
		if(!isset($_SESSION['uid']) or !isset($_SESSION['username'])){
			$this->error('您还没有登录','?c=login');
		}
		//加载公共css样式,js库
		$css=array('bootstrap.css','font-awesome.css','animate.min.css');
		$_css=load_file($css,'Extend.Org.Bootstrap','css');
		$this->assign('css',$_css);
		$js=array('jquery-1.10.2.min.js');
		$_js=load_file($js,'Extend.Org.js','js');
		$this->assign('js',$_js);
	}
}