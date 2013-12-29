<?php
class IndexController extends CommonController{

	public function __construct(){
		parent::__construct();
	}
	public function index(){
		//分类
		$_category=new Model('category');
		$cate=$_category->select();
		import("Lib.Category");
		$category=Category::unlimitedForLayer($cate);
		foreach ($category as $k=>$v) {
			$order=array();
			foreach ($v['child'] as $v1) {
				$order[]=$v1['sort'];
			}
			array_multisort($order, SORT_DESC, $category[$k]['child']);
		}
		//问题列表
		$_ask=new Model('ask');
		$ask=$_ask->order('time')->select();
		//变量分配
		$this->assign('category',$category);
		$this->assign('ask',$ask);
		$this->display('Index/index.php');
	}
}