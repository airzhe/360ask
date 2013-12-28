$(document).ready(function(){
	// 弹出层
	
	// $('body').on('click','.login,.register,.modal-title .close',modal)//
	//验证码
	$("body").on('click','#code',function(){
			$('#code').attr('src','?c=user&m=code&'+Math.random());//记住这一行
		})
	//登录注册
	$('body').on('click','.login',function(){
		$.modal({
			top:150,
			title:'登录',
			footer:false,
			callback:function(modal){
				modal.find('.modal_body').load(loginPath + ' #loginForm',function(){
					$.getScript(loginVerifyPath);
				});		
			}
		})	
	})
	$('body').on('click','.register',function(){
		$.modal({
			top:100,
			title:'用户注册',
			footer:false,
			callback:function(modal){
				modal.find('.modal_body').load(registPath + ' #registerForm',function(){
					$.getScript(registVerifyPath);
				});		
			}
		})		
	})
	//首页左侧菜单
	$('#category').find('li').on('mouseenter',function(){
		$(this).addClass('active');//切换样式
		var top=($(this).position().top)-1;
		$('#category').find('.sub').find('.more').eq($(this).index()).css('top',top).removeClass('hide');
	})
	$('#category').find('li').on('mouseleave',function(){
		var self=$(this);
		var index=self.index();
		self.removeClass('active')
		var timer=setTimeout(function(){
			$('#category').find('.sub').find('.more').eq(index).addClass('hide');
		},1)
		$('#category').find('.more').eq(index).hover(function(){
			clearTimeout(timer)
			self.addClass('active')
			$('#category').find('.sub').find('.more').eq(index).removeClass('hide');
		},function(){
			self.removeClass('active')
			$('#category').find('.sub').find('.more').eq(index).addClass('hide');
		})		
	})
	//头部导航分类二级菜单
	$('#mav_category').on('mouseenter',function(){
		$('#navigate').find('.category').removeClass('hide');
	})
	$('#mav_category').on('mouseleave',function(){
		var timer=setTimeout(function(){
			$('#navigate').find('.category').addClass('hide');
		},100)
		$('#navigate').find('.category').hover(function(){
			clearTimeout(timer);
			$('#navigate').find('.category').removeClass('hide');
		},function(){
			$('#navigate').find('.category').addClass('hide');
		})
	})
	// 轮播图
	var slide=$('.slide');
	slide.find('.item:gt(0)').hide();
	$('.slide-nav').find('li').hover(function(){
		var index=$(this).index();
		slide.find('.item').eq(index).show().siblings().hide();
		$(this).addClass('selected').siblings().removeClass('selected');
	})
	//邮件验证,点此重发一封.  =============!!!没有对发送次数做判断!!!=============
	var send_num=0;
	$('body').on('click','#send_again',function(){
		console.log(send_num);
		if (send_num>=3){alert('每天发送次数为3次，请改天再试');return;}
		var self=$(this);
		var email=$('.email_verify_tips').find('.email').text();
		var username=$('.email_verify_tips').find('.email').data('user');
		$.ajax({
			url:'?c=user&m=email',
			type:'post',
			data:{email:email,username:username},
			success:function(data){
				if(data==1){
					send_num++;
					self.next('span').text('发送成功!')
					setTimeout(function(){
						self.next('span').text('');
					},2000)
				}else{
					self.next('span').text('发送失败，请重试!')
				}
			}
		})
	})
	// user用户中心
	//百分比插件
	// $('.chart').easyPieChart({
	// 	barColor: '#d53f40'
 //        //your configuration goes here
 //    });
	//ajax加载内容
	$('#userCenter').children('.left').find('li').click(function(){
		var self=$(this);
		self.addClass('current').siblings('li').removeClass('current');//点击添加当前样式
		var right=$('.right')
		var content=right.children('.content');
		var loading=right.find('.loading');
		loading.show();
		$('.right').find('h3').text($(this).text());
		content.fadeOut('400', function() {
			switch (self.data('href')){
				case 'achievement':
				$('.achievement').show().siblings().hide();
				break;
				case 'question':
				$('.question').show().siblings().hide();
				break;
				case 'answer':
				$('.answer').show().siblings().hide();
				break;
				case 'message':
				$('.message').show().siblings().hide();
				break;
			}
			content.fadeIn();
			loading.hide();
		});
	})

	/*提问页面ask*/
	//获得文字长度(英文两个算一个字符，中文汉字占一个字符。)
	var getMessageLength = (function() { 
		var byteLength = function(b) { 
			if(typeof b == "undefined") { 
				return 0; 
			} 
			var a = b.match(/[^\x00-\x80]/g); 
			return(b.length + (!a ? 0 : a.length)); 
		}; 
		return function(message) { 
			message = message || ''; 
			message = message.replace(/\r\n/g, "\n"); 
			var c = 41, 
			d = 140, 
			e = 20, 
			f = message, 
			g = message.match(/http:\/\/[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+([-A-Z0-9a-z_\$\.\+\!\*\(\)\/,:;@&=\?\~\#\%]*)*/gi) || [], 
			h = 0; 

			for(var i = 0, j = g.length; i < j; i++) { 
				var k = byteLength(g[i]); 
				if(/^(http:\/\/t.cn)/.test(g[i])) { 
					continue; 
				} 
				/^(http:\/\/)+(t.sina.com.cn|t.sina.cn)/.test(g[i]) || /^(http:\/\/)+(weibo.com|weibo.cn)/.test(g[i]) ? h += k <= c ? k : k <= d ? e : k - d + e : h += k <= d ? e : k - d + e; 
				f = f.replace(g[i], ""); 
			} 
			var l = Math.ceil((h + byteLength(f)) / 2); 
			return l; 
		}; 
	})(); 

	// $('#ask').on('submit',function(){return false;})
	//得到失去焦点改变样式
	$('#question').focus(function(){
		$(this).addClass('success');
	})
	$('#question').blur(function(){
		if(!$(this).hasClass('error')){
			$(this).removeClass();
		}
	})
	/*鼠标按下动态改变文字数量。并检测文字长度显示相应样式。*/
	$('#question').on('keyup',function(){
		var count=getMessageLength($(this).val());
		var obj_count=$('#ask').find('i.count');
		var ico=$('#ask').find('s');
		if(count!=0)ico.removeClass('hide');
		obj_count.text(count);
		//检测输入框文本长度
		if(count<5 || count>50){
			//长度不符合条件
			$(this).removeClass().addClass('error');
			ico.removeClass().addClass('error');
			if(count>50){
				console.log(count);
				obj_count.addClass('error')
			}
		}else{
			//长度合条件
			$(this).removeClass().addClass('success');
			obj_count.removeClass('error');
			ico.removeClass().addClass('success');
		}
	})
	$('button').on('click',function(){
		var ask_content=$.trim($('textarea').val());
		$('textarea').attr('class','');
		$('textarea').addClass('empty');
		setTimeout(function(){
			$('textarea').removeClass('empty');
		},800)
	})
	
})