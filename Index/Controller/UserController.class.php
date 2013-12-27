<?php 
class UserController extends CommonController{
	private $db;
	public function status(){
		$this->display('User/status.php');
	}
	public function login(){
		if(!empty($_POST)){

		}else{
			$this->display('User/login.php');
		}
	}
	public function regist(){
		if(!empty($_POST)){
			if(empty($_POST)) die;
			$member=array();
			if(!preg_match('@^\w{6,10}$@is', $_POST['username'])) die('用户名错误');
			if(!preg_match('@^.{6,20}$@is', $_POST['password'])) die('密码错误');

			$member['username']=addslashes(strtolower(trim($_POST['username'])));
			$member['passwd']=md5(trim($_POST['password']));
			$member['email']=addslashes(strtolower(trim($_POST['email'])));
			$member['registime']=time();
			
			// ============!!!数据没有验证，只做测试使用!!!==============
			$_member=new Model('member');
			$uid=$_member->add($member);
			if($uid)
			{
				session_id() || session_start();
				$_SESSION['uid']=$uid;
				$_SESSION['uname']=$member['username'];
				$this->success('注册成功');
			}else{
				$this->error('注册失败');
			}
		}else{
			$this->display('User/register.php');
		}
	}
	//产生验证码
	public function code(){
		session_id() || session_start();
		import("Lib.Code");
		$code=new Code();
		$code->font_color='#000000';
		$code->font=C('FONT');
		$code->show();
	}
	//异步验证验证码
	public function check_code(){
		session_id() || session_start();
		$code=isset($_POST['code'])?strtoupper(trim($_POST['code'])):'';
		if($code==$_SESSION['code']){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	//异步验证邮箱是否注册
	public function check_email(){
		$member=new Model('member');
		$email=isset($_POST['email'])?strtolower(trim($_POST['email'])):'';
		if(!$email)die;
		if(!$member->where("email='$email'")->count()){
			die('true');
		}else{
			die('false');
		}
	}
}