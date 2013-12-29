jQuery.validator.addMethod("userNameFormat", function(value) {  
	return (/^\w+$/.test(value));
}, "用户名只能由字母、数字、下划线组成");
	//注册验证
	$('#registerForm').validate({
		submitHandler:function(form){
			$(form).find('button').html('<s class="loading"></s>');
			$.ajax({
				url:'?c=user&m=regist',
				type:'post',
				data:'a=login&' + $(form).serialize(),
				success:function(data){
					if(data==1){
						var email=$(form).find('[name=email]').val();
						var username=$(form).find('[name=username]').val();
						activeEmail(email,username);
					}else{
						alert('注册失败');
					}
				}
			})
		},
		onkeyup:false,
		rules:{
			email:{
				required:true,
				email:true,
				remote: {
				    url: "?c=user&m=check_email",	//后台处理程序
				    type: "post",               	//数据发送方式 
				    data: {                     	//要传递的数据
				    	email: function() {
				    		return $("[name=email]").val();
				    	}
				    }
				}
			},
			username:{
				required:true,
				rangelength:[6,20],
				userNameFormat:true,
				remote: {
				    url: "?c=user&m=check_user",	//后台处理程序
				    type: "post",               	//数据发送方式 
				    data: {                     	//要传递的数据
				    	username: function() {
				    		return $("[name=username]").val();
				    	}
				    }
				}
			},
			password:{
				required:true,
				rangelength:[6,20]
			},
			repassword:{
				required:true,
				equalTo:"#pwd"
			},
			code:{
				required:true,
				remote: {
					    url: "?c=user&m=check_code",	//后台处理程序
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
				email:{
					required:'请输入邮箱地址',
					email:'请输入正确的邮箱地址',
					remote:'邮箱地址已经存在，请更换。'
				},
				username:{
					required:'用户名不能为空',
					rangelength:'用户名长度为6-20位',
					remote:'用户名已经存在，请更换。'
				},
				password:{
					required:'请设置密码',
					rangelength:'密码长度为6-20位'
				},
				repassword:{
					required:'请输入确认密码',
					equalTo:'两次密码不一致'
				},
				code:{
					required:'请输入验证码',
					remote:'验证码错误'
				}
			},
		success: function(label) {    //label指向上面那个错误提示信息标签em  
			var obj=$(label).parent();
			obj.find('input').removeClass('has-error').addClass('success');
			obj.find('i').removeClass('unchecked').addClass('checked');
		},
		highlight: function(element, errorClass) {
			var obj=$(element).parent();
			obj.find('input').removeClass('success').addClass('has-error');
			obj.find('i').removeClass('checked').addClass('unchecked');
		}
	})