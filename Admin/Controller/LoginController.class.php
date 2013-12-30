<?php
class LoginController extends Controller{
	public function __construct(){
		//如果登录了不显示页面直接跳转;
		session_id() || session_start();
		if(isset($_SESSION['uid']) and isset($_SESSION['username'])){
			header('Location:?c=index');
		}else{
			$js=array('jquery-1.10.2.min.js','jquery.validate.js');
			$_js=load_file($js,'Extend.Org.js','js');
			$this->assign('js',$_js);
		}
	}
	//登录页面
	public function index(){
		$this->assign('title','后台用户登录');
		$this->display('Login/login.php');
	}
	//用户名密码验证
	public function check(){
		$data=isset($_POST)?$_POST:'';
		if(empty($data))die;
		//验证码检测
		ob_start();
		$this->check_code();
		$check_code=ob_get_contents();
		ob_clean();
		if($check_code=='false') die('验证码错误');
		//用户验证
		$username=addslashes($_POST['username']);
		$passwd=md5($_POST['password']);
		$_where=array('username'=>$username,'passwd'=>$passwd);
		$db=new Model('admin');
		$user=$db->where($_where)->find();
		if($user){
			session_id() || session_start();
			$_SESSION['uid']=$user['id'];
			$_SESSION['username']=$user['username'];
			$this->success('登录成功','?c=index');
		}else{
			$this->error('用户名，密码错误','?c=login');
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
}