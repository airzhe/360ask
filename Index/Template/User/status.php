<?php
session_id() || session_start();
if(!isset($_SESSION['uid']) or !isset($_SESSION['uname']) ):
	?>
<div class="info">
	<a href="javascript:void(0)" class="login"><s></s>登录</a>
	<a href="javascript:void(0)" class="register"><s></s>注册</a>
</div>
<?php
else:
	$_member=new Model('member');
	$me=$_member->where(array('uid'=>$_SESSION['uid']))->find();
	//头像
	if($me['avatar']){
		$me['avatar']=C('UPLOAD_DIR').'avatar/small/'.$me['avatar'];
	}else{
		$me['avatar']=C('TPL_PUBLIC').'images/avatar.png';
	}
?>
<div class="info">
	<a href="?c=member&amp;uid=<?php echo $_SESSION['uid']?>"><img src="<?php echo $me['avatar']?>" alt="" width='35' height='35'></a>
	<span class="userName"><?php echo $_SESSION['uname']?></span>
	<a href="javascript:void(0);" class="logout">退出</a>
</div>
<div>
	<ul class="clearfix">
		<li>
			回答数<br>
			<span>0</span>
		</li>
		<li>采纳率<br>
			<span>0%</span>
		</li>
		<li>提问数<br>
			<span>0</span>
		</li>
	</ul>
</div>
<?php
endif;
?>