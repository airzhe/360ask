jQuery.validator.addMethod("userNameFormat", function(value) {  
	return (/^\w+$/.test(value));
}, "用户名只能由字母、数字、下划线组成");
	//登录验证
	$('#loginForm').validate({
		submitHandler:function(form){
			$(form).find('button').html('登录中<span>...</span>');
			$.ajax({
				url:'?c=user&m=login',
				type:'post',
				dataType:'json',
				data:$(form).serialize(),
				success:function(data){
					if(data.status==1){
						setTimeout(function(){
							$('.close').click();
							userStatus();
						},1000)//测试用
					}else if(data.status==2){
						var email=data.email;
						var username=data.username;
						activeEmail(email,username);
					}else{
						$(form).find('button').html('立即登陆');
						$('[name=username').removeClass('success').addClass('has-error')//提示用户名错误
						.siblings('label').html('用户名或密码错误,请重试。')
						.siblings('i').attr('class','');
						$('[name=password').attr('class','').siblings().attr('class','');//删除success样式
					}
				}
			})
		},
		rules:{
			username:{
				required:true,
				rangelength:[6,20],
				userNameFormat:true
			},
			password:{
				required:true,
				rangelength:[6,20]
			}
		},
		messages:{
			username:{
				required:'用户名不能为空',
				rangelength:'用户名长度为6-20位'

			},
			password:{
				required:'密码不能为空',
				rangelength:'密码长度为6-20位'
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
