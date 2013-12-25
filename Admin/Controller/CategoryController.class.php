<?php
/**
 * 分类管理
 */
class CategoryController extends CommonController{
	public function index(){
		$db=new Model('category');
		$this->display('Category/index.php');
	}
}