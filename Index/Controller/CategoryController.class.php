<?php
class Categorycontroller extends CommonController{
	public function index(){
		$cid=isset($_GET['cid'])?(int)$_GET['cid']:0;
		if(!$cid)die;
		$_category=new Model('category');
		//当前分类名称
		$current_cate=$_category->where(array('cid'=>$cid))->find();
		//子分类名称
		//上次的查询影响到到了类里方法，影响到了这次查询的结果。
		$_category->opt['limit']='';
		$child_cate=$_category->where(array('pid'=>$cid))->select();
		
		$this->assign('current_cate',$current_cate);
		$this->assign('child_cate',$child_cate);
		// p($child_cate);
		$this->display('Category/index.php');
	}
	
}