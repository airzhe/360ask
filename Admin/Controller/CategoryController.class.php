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
	public function edit(){
		$this->assign('title','编辑分类');
		$this->display('Category/edit.php');
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
	public function del(){
		$cid=isset($_GET['cid'])?(int)$_GET['cid']:0;
		if(!$cid)return;
		if($this->db->where("cid=$cid")->del()){
			die('1');
		}else{
			die('0');
		}
	}
}