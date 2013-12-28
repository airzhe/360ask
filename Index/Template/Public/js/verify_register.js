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
						$.ajax({
							url:'?c=user&m=email',
							type:'post',
							data:{email:email,username:username},
							success:function(data){
								if(data==1){
									var suffix=email.split("@");
									var url='http://email.' + suffix['1'];
									var msg='';
									msg +='<div class="email_verify_tips">'
									msg +='<p>验证邮件已经发送到 <span class="email" data-user="'+ username +'">' + email + '</span></p>';
									msg +='<p>您需要点击邮箱中的确认链接来完成</p>';
									msg +='<p><a href="' + url + '" target="_blank">立即进入邮箱</a></p>';
									msg +='<p class="title">没有收到确认链接怎么办？</p>';
									msg +='<p>1 看看是否在邮箱的回收站中，垃圾箱中</p>';
									msg +='<p>2 确认没有收到，<a href="javascript:void(0);" id="send_again">点此重发一封</a>&nbsp;&nbsp;&nbsp;<span></span></p>';
									msg +='</div>'
									$.modal({
										title:'消息提示',
										footer:false,
										body: msg,
									})
								}else{
									alert('出错了，请重试。')
								}
							}
						})
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