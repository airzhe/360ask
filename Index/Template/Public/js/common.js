//用户登录状态
function userStatus(){//用户登录状态刷新
	$('.sidebar').find('.user').load(userStatusPath,function(){
		var info=$(this).find('.info').html();
		$('#search').find('.user').html(info).find('a').has('img').addClass('userAvatar');;
	})
}
$(document).ready(function() {
	function _init(){//初始化
		userStatus();
	}
	_init();
});