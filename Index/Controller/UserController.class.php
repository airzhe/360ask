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
				// session_id() || session_start();
				// $_SESSION['uid']=$uid;
				// $_SESSION['uname']=$member['username'];
				die('1');
			}else{
				die('0');
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

	//异步验证用户名是否存在
	public function check_user(){
		$member=new Model('member');
		$username=isset($_POST['username'])?strtolower(trim($_POST['username'])):'';
		if(!$username)die;
		if(!$member->where("username='$username'")->count()){
			die('true');
		}else{
			die('false');
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
	//发送邮箱验证链接
	public function email(){
		$email=isset($_POST['email'])?trim($_POST['email']):'532499602@qq.com';
		$username=isset($_POST['username'])?trim($_POST['username']):'purple';
		if(!$email || !$username) die;
		import("Org.Mail.Mailer");
		import("Org.Mail.Smtp");
		$mail = new PHPMailer;
		$system_email=C('EMAIL');	//系统邮箱
		$email_passwd=C('EMAIL_PASSWD');
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.163.com';  						  // Specify main and backup server
		$mail->Port = 465;                   				  // SMTP服务器的端口号
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $system_email;                      // SMTP username
		$mail->Password = $email_passwd;          			 // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted 必须开启openssl模块
		$mail->From = $system_email;							//必须和用户名一致
		$mail->FromName = '360问答';								//邮件列表发件人
		$mail->addAddress($email, $username);  					// Add a recipient
		$mail->addReplyTo($system_email, '360问答');				//回复邮箱

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->isHTML(true);                                  // Set email format to HTML
		$auth=authcode($email,'ENCODE',C('TOKEN'),C('AUTH_LINK_EXPIRED'));		 //邮箱加密
		$examurl=urlencode($auth);

		$date=date('Y-m-d H:i:s');
		$mail->Subject = "360问答邮箱认证-{$username}";
		$mail->Body    = <<<str
亲爱的360问答用户 <strong>{$username}</strong>：
<br />
<br />
感谢你对360问答的支持与厚爱，请点击以下链接完成邮箱认证(如无法打开请把链接复制到浏览器打开)。
<br />
<a href='{$_SERVER["HTTP_REFERER"]}?c=user&m=verify_email&code={$examurl}'>{$_SERVER["HTTP_REFERER"]}?c=user&m=verify_email&code={$examurl}</a>
<br />
<br />
360问答邮件中心
<br />
{$date};
str;
		if($mail->send()) {
			die('1');
		}else{
			die('0');
		}
	}
	//邮箱验证
	public function verify_email(){
		$code=isset($_GET['code'])?$_GET['code']:'';
		if(!$code)die;
		$email=authcode($code,'DECODE',C('TOKEN'));
		if(!$email)die;
		if($email==md5('Timeout')){
			die('链接已超时');
		}else{
			$member=new Model('member');
			$data['verification']=1;
			if($member->where("email='$email'")->save($data)){
				$userinfo=$member->where("email='$email'")->find();
				session_id() || session_start();
				$_SESSION['uid']=$userinfo['uid'];
				$_SESSION['uname']=$userinfo['username'];
				$msg='恭喜你 <b>'.$userinfo['username'].'</b>，您的邮箱已成功激活。';
				$this->success($msg,'./');
			}
		}
	}
}