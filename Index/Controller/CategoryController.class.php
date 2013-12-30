<?php
class Categorycontroller extends CommonController{
	public function index(){
		$cid=isset($_GET['cid'])?(int)$_GET['cid']:0;
		// if(!$cid)die;
		$_category=new Model('category');
		//当前分类名称
		$current_cate=$_category->where(array('cid'=>$cid))->find();
		//子分类名称
		//上次的查询影响到到了类里方法，影响到了这次查询的结果。
		$_category->opt['limit']='';
		$child_cate=$_category->where(array('pid'=>$cid))->select();
		//导航二级菜单
		$_category->opt['where']='';
		$cate=$_category->select();
		import("Lib.Category");
		$category=Category::unlimitedForLayer($cate);
		$this->assign('category',$category);
		//面包屑导航
		$path=Category::getParents($cate,$cid);
		$this->assign('path',$path);
		$this->assign('current_cate',$current_cate);
		$this->assign('child_cate',$child_cate);
		//通过 IN 获得问题列表
		$_ask=new Model('ask');
		$_cid=Category::getChildsId($cate,$cid);
		if(!empty($_cid)){
			$cids=implode(',',$_cid);
		}else{
			$cids=$cid;
		}
		$ask=$_ask->where("cid in ($cids)")->select();
		$_answer=new Model('answer');
		foreach ($ask as $k => $v) {
			$re_count=$_answer->where(array('aid'=>$v['aid']))->count();
			$ask[$k]['re_count']=$re_count;
		}
		
		$this->assign('ask',$ask);
		$this->display('Category/index.php');
	}
	
}