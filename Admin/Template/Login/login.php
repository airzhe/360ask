<?php require C('TPL_PUBLIC').'header.php';?>
<script>
	$(document).ready(function(){
		$("#code").on('click',function(){
			$('#code').attr('src','?c=login&m=code&'+Math.random());//记住这一行
		})
		$('#login_form').validate({
			onkeyup:false,
			errorLabelContainer: $("small.error"),
			rules:{
				username:{
					required:true,
				},
				password:{
					required:true,
				},
				code:{
					required:true,
					remote: {
					    url: "?c=login&m=check_code",	//后台处理程序
					    type: "post",               	//数据发送方式 
					    data: {                     	//要传递的数据
					    	code: function() {
					    		return $("[name=code]").val();
					    	}
					    }
					}
				}
			},
			messages:{
				username:{
					required:'用户名不能为空'
				},
				password:{
					required:'密码不能为空'
				},
				code:{
					required:'验证码不能为空',
					remote:'验证码错误'
				},
			}
		})
	})
</script>
</head>
<body id="login">
	<form id="login_form" action='?c=login&amp;m=check' method='post'>
		<h2>请登录<small class="error"></small></h2>
		<!-- <ul class='error'></ul> -->
		<input type="text" placeholder="帐号" name="username" class="username">
		<input type="password" placeholder="密码" name="password" class="passwd">
		<label for="">验证码：</label><input type="text" name='code'><img src="?c=login&amp;m=code" alt="" id="code"><br/>
		<br/>
		<p><input type="submit" value="登录"></p>
	</form>
</body>
</html>