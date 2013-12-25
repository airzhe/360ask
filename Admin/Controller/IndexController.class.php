<?php
class IndexController extends CommonController{
	public function index(){
		$this->assign('title','360问答后台管理');
		$this->display('Index/index.php');
	}
}