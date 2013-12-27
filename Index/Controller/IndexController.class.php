<?php
class IndexController extends CommonController{

	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$_category=new Model('category');
		$cate=$_category->select();
		import("Lib.Category");
		$category=Category::unlimitedForLayer($cate);
		$this->assign('category',$category);
		$this->display('Index/index.php');
	}
}