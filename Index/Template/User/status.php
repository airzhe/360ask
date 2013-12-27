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
	?>
<div class="info">
	<a href=""><img src="<?php echo C('TPL_PUBLIC')?>images/avatar.jpg" alt="" width='35' height='35'></a>
	<span class="userName"><?php echo $_SESSION['uname']?></span>
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