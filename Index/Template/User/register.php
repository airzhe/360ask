<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>用户注册</title>
</head>
<body>
	<form action="?c=user&amp;m=regist" id="registerForm" method="post">
		<div class="form-group">
			<p><label for="" >邮箱</label><input type="text" name="email" placeholder="请输入邮箱" /><i></i></p>
		</div>
		<div class="form-group">
			<p><label for="" >用户名</label><input type="text" name="username" placeholder="请输入用户名" /><i></i></p>
		</div>
		<div class="form-group">
			<p>	<label for="">密码</label><input type="text" name="password"/ id="pwd"><i></i></p>
		</div>
		<div class="form-group">
			<p>	<label for="">确认密码</label><input type="text" name="repassword"/><i></i></p>
		</div>
		<div class="form-group">
			<p>	<label for="">验证码</label><input type="text" name="code"/><i></i><img src="?c=user&amp;m=code" id="code" ></p>
			<p ><button>立即注册</button></p>
		</div>
	</form>
</body>
</html>