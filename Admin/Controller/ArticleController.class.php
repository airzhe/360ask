<?php
class ArticleController extends Controller{
	public $db;
	public function __construct(){
		$this->db=new Model('article');
	}
	public function show(){
		$_data=$this->db->select();
		$this->assign('data',$_data);
		$this->assign('title','文章列表页面');
		import("Lib.Code");
		$this->display('Article/show.php');
	}
	public function add(){
		$this->assign('title','文章添加页面');
		if(!empty($_POST)){
			if($this->db->add()){
				// p(get_class_methods('Model'));
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display('Article/add.php');
		}	
	}
	public function edit(){
		$this->assign('title','文章编辑页面');
		$id=isset($_GET['id'])?(int)$_GET['id']:null;
		if(!$id) return;
		if(!empty($_POST)){
			if($this->db->where("id=$id")->save()){
				$this->success('编辑成功');
			}else{
				$this->error('编辑失败');
			}
		}else{
			$data=$this->db->where("id=$id")->find();
			$this->assign('data',$data);
			$this->display('Article/edit.php');
		}

	}
	public function del(){
		$id=isset($_GET['id'])?(int)$_GET['id']:null;
		if(!$id) return;
		$this->db->where("id=$id");
		if($this->db->del()){
			$this->success('删除成功');
		}else{
			$this->error("删除失败");
		}
	}
}