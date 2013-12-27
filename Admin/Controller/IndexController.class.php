<?php
class IndexController extends CommonController{
	public function index(){
		$this->assign('title','360问答后台管理');
		$this->display('Index/index.php');
	}
	public function logout(){
		session_id() || session_start();
		session_unset();
		session_destroy();
		header('location:?c=login');
	}
}