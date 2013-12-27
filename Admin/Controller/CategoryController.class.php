<?php
/**
 * 分类管理
 */
class CategoryController extends CommonController{
	private $db;
	public function __construct(){
		parent::__construct();
		$this->db=new Model('category');
	}
	public function index(){
		$category=$this->db->select();
		import("Lib.Category");
		$_category=Category::unlimitedForLevel($category);
		$this->assign('category',$_category);
		$this->display('Category/index.php');
	}
	//添加分类
	public function add(){
		$this->assign('title','添加分类');
		if(!empty($_POST)){
			if($this->db->add()){
				$this->success('分类添加成功','?c=category&amp;');
			}else{
				$this->error('添加失败','?c=category&amp;');
			}
		}else{
			$pid=isset($_GET['pid'])?(int)$_GET['pid']:0;
			$p_cate=$this->db->where("cid=$pid")->find();
			$this->assign('pid',$pid);
			$this->assign('pname',$p_cate['cname']);
			$this->display('Category/add.php');
		}
	}
	//编辑分类
	public function edit(){
		$this->assign('title','编辑分类');
		if(!empty($_POST)){
			if($this->db->save()){
				$this->success('编辑成功','?c=category&amp;');
			}else{
				$this->error('编辑失败','?c=category&amp;');
			}
		}else{
			//上级分类
			$pid=isset($_GET['pid'])?(int)$_GET['pid']:0;
			$p_cate=$this->db->where("cid=$pid")->find();
			//本分类
			$cid=isset($_GET['cid'])?(int)$_GET['cid']:0;
			$c_cate=$this->db->where("cid=$cid")->find();
			$cate=array('cid'=>$cid,'cname'=>$c_cate['cname'],'aliases'=>$c_cate['aliases'],'pname'=>$p_cate['cname']);
			$this->assign('cate',$cate);
			$this->display('Category/edit.php');
		}
	}
	//异步编辑
	public function ajax_edit(){
		if(empty($_POST))return;
		$cid=$_POST['cid'];
		$_data=explode('@=@',$_POST['arg']);
		list($k,$v)=$_data;
		$data[$k]=$v;
		$result=$this->db->where("cid=$cid")->save($data);
		if($result){
			die('1');
		}else{
			die('0');
		}
	}
	//异步删除
	public function del(){
		$cid=isset($_GET['cid'])?(int)$_GET['cid']:0;
		if(!$cid)return;
		$children=$this->db->where("pid=$cid")->count();
		if($children) die('2');
		if($this->db->where("cid=$cid")->del()){
			die('1');
		}else{
			die('0');
		}
	}
}