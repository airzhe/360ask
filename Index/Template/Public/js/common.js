//用户登录状态
function userStatus(){//用户登录状态刷新
	$('#search').find('.user').load(userStatusPath,function(){
		if($('.sidebar').length!=0){
			$('.sidebar').find('.user').html($(this).html());
		}
		$(this).find('a').has('img').addClass('userAvatar');
		$(this).find('ul').remove()
	})
}
//发送邮件，验证邮箱
function activeEmail(email,username){
	$.ajax({
		url:'?c=user&m=email',
		type:'post',
		data:{email:email,username:username},
		success:function(data){
			if(data==1){
				var suffix=email.split("@");
				var url='http://mail.' + suffix['1'];
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
}
//
function success(msg){
	alert(msg);
}
function error(msg){
	alert(msg);
}
$(document).ready(function() {
	function _init(){//初始化
		userStatus();
	}
	_init();
});