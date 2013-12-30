<?php
class AskController extends CommonController{
	//提问页面
	public function question(){
		$question=isset($_POST['q'])?htmlspecialchars(trim($_POST['q'])):'';
		$this->assign('question',$question);
		$this->display('Ask/question.php');
	}
	//获取相应ID的子分类
	public function category(){
		$pid=$_GET['pid']?(int)$_GET['pid']:0;
		$category=new Model('category');
		$result=$category->where("pid='$pid'")->select();
		if(!empty($result)){
			die(json_encode($result));
		}else{
			die('0');
		}
	}
	//提交问题
	public function submit(){
		$data['title']=$_POST['title'];
		$data['content']=$_POST['content'];
		$data['cid']=$_POST['cid'];
		session_id() || session_start();
		$data['uid']=$_SESSION['uid'];
		$data['is_hide']=isset($_POST['is_hide'])?1:0;
		$data['time']=time();
		if(empty($data))die;//========================!!!数据没有做正则验证!!!===============
		$ask=new Model('ask');
		if($ask->add($data))
		{
			$this->success('提交成功!');
		}else{
			$this->error('提交失败，请重试。');
		}
	}
	//问题展示页面
	public function show(){
		//问题
		$aid=isset($_GET['aid'])?(int)$_GET['aid']:null;
		if(!$aid) die;
		session_id() || session_start();
		$s_uid=isset($_SESSION['uid'])?$_SESSION['uid']:null;
		$_ask=new Model('ask');
		$_ask->exec("update ask set hits=hits+1 where aid='$aid'");
		$ask=$_ask->where("aid='$aid'")->find();
		$_member=new Model('member');
		if(!$ask['is_hide']){
			$user=$_member->where(array('uid'=>$ask['uid']))->find();
			$ask['uname']=$user['username'];
		}else{
			$ask['uname']='匿名';
		}
		//回复
		$_answer=new Model('answer');
		$answer=$_answer->where("aid='$aid'")->order('time desc')->select();
		
		foreach ($answer as $k => $v) {
			$user=$_member->where(array('uid'=>$v['uid']))->find();
			if(!$v['is_hide']){
				$uname=$user['username'];
			}else{
				$uname='匿名';
			}
			$answer[$k]['uname']=$uname;
			//得到最佳答案的id
			if($ask['sid']){
				if($v['sid']==$ask['sid']){
					unset($answer[$k]);
					$ado=$v;
					$ado['uname']=$uname;
					$this->assign('ado',$ado);
				}
			}
	}
	//面包屑导航
	import("Lib.Category");
	$_category=new Model('category');
	$cate=$_category->select();
	$path=Category::getParents($cate,$ask['cid']);
	$this->assign('path',$path);

	$answer_count=count($answer);
	$this->assign('s_uid',$s_uid);
	$this->assign('ask',$ask);
	$this->assign('answer',$answer);
	// p($answer);
	$this->assign('answer_count',$answer_count);
	$this->display('Ask/show.php');
}
	//回复问题
public function replay(){
	if(empty($_POST))die;
	$data['content']=htmlspecialchars($_POST['content']);
	$data['aid']=$_POST['aid'];
		//问题发布者ID
	$_ask=new Model('ask');
	$ask=$_ask->where(array('aid'=>$_POST['aid']))->find();
	session_id() || session_start();
	if($ask['uid']==$_SESSION['uid'])die('不能回复自己的提问！');
		//回复者ID
	$data['uid']=$_SESSION['uid'];
	$data['is_hide']=isset($_POST['is_hide'])?1:0;
	$data['time']=time();
	$ask=new Model('answer');
	$url='?c=ask&m=show&aid='.$data['aid'];
	if($ask->add($data))
	{
		$this->success('回复成功',$url);
	}else{
		$this->error('回复失败');
	}

}
	//采纳为最佳答案
public function adoption(){
	$aid=$_POST['aid'];
	$sid=$_POST['sid'];
	if(!$aid || !$sid) die;
	$_ask=new Model('ask');
	if($_ask->where("aid=$aid")->save(array('sid'=>$sid))){
		die('1');
	}else{
		die('0');
	}
}
}