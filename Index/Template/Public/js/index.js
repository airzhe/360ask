$(document).ready(function(){
	//验证码
	$("body").on('click','#code',function(){
			$('#code').attr('src','?c=user&m=code&'+Math.random());//记住这一行
		})
	//登录注册
	$('body').on('click','.login',function(){
		$.modal({
			top:150,
			title:'欢迎登录360问答',
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
			title:'欢迎注册360问答',
			footer:false,
			callback:function(modal){
				modal.find('.modal_body').load(registPath + ' #registerForm',function(){
					$.getScript(registVerifyPath);
				});		
			}
		})		
	})
	//logout
	$('body').on('click','.logout',function(){
		$.ajax({
			url:'?c=user&m=logout',
			success:function(){
				userStatus();
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
	var i=0;
	var adTimer;
	slide.find('.item:gt(0)').hide();
	$('.slide-nav').find('li').mouseenter(function(){
		var index=$(this).index();
		showImage(index);
		clearInterval(adTimer);
	})
	$('.slide-nav').find('li').mouseleave(function(){
		adTimer=setInterval(function(){
			showImage(i);
			i++;
			if (i>2)i=0;
		},1500)
	})
	 $('.slide-nav').find('li').first().trigger('mouseleave');
	function showImage(index){
		var index=index;
		$('.slide-nav').find('li').eq(index).addClass('selected').siblings().removeClass();
		slide.find('.item').eq(index).show().siblings().hide();
		$(this).addClass('selected').siblings().removeClass('selected');
	}
	//邮件验证,点此重发一封.  =============!!!没有对发送次数做判断!!!=============
	var send_num=0;
	$('body').on('click','#send_again',function(){
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

	$('#ask').on('submit',function(){return false;})
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
	$('#question').on('keydown',function(){
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
			$("#ask").find('button').find('s').css('background-position','0 0');
		}
	})
	//
	function changeCategory(pid){
		//如果为不选就返回
		if(pid=='不选')return;
		// modal.find('.modal_body').html('');
		var str='<select class="category" name="category[]" size=12><option selected class="null">不选</option>';
		$.ajax({
			url:'?c=ask&m=category',
			data:'pid=' + pid,
			type:'get',
			dataType:'json',
			success:function(data){
				if(data==0)return;
				$.each(data,function(i,n){
					str+='<option value="' + data[i]['cid'] + '">' + data[i]['cname'] + '</option>';
				})
				str+='</select>';
				$('.modal_body').append(str);
				if(pid==0){
					$('.category').val('200').find('.null').remove();
				}
			}
		})
	}
	//显示选择分类对话框
	$('.selectCategory').on('click',function(){
		$.modal({
			top:100,
			title:'请选择问题分类',
			body:'',
			// footer:false,
			callback:changeCategory(0)
		})
		if($('#ask_category').find('span').length==0){
			$('#ask_category').prepend('分类：<span data-cid="200">其他</span> ').find('a').text('[更改]').css('margin-left','5px');
		}
		//点击确定按钮获得所选分类ID
		$('.modal_footer').find('button').first().on('click',function(){
			var cid=$('#ask_category').find('span').last().data('cid');
			// console.log(pid);
			$('#ask').find('[name=cid]').val(cid);
			$('.modal').find('.close').trigger('click');
		})
		$('.modal_footer').find('button').last().on('click',function(){
			$('.modal').find('.close').trigger('click');
		})
	})
	//分类改变显示下级分类
	$('body').on('change','.category',function(){
		var pid=this.value;		
		var pname=$(this).find("option:selected").text();
		// console.log([pid,pname]);
		$(this).next('select').remove();
		changeCategory(pid);

		var index=$(this).index('.category');
		var _cate=$('#ask_category');
		if(index==0){
			_cate.find('span').eq(0).text(pname).data('cid',pid).nextAll('span').remove();
		}else{
			if(pid=='不选'){
				_cate.find('span').eq(index).remove();
				return;
			}
			pname=' > ' + pname;
			if(_cate.find('span').eq(index).length==0){
				_cate.find('a').before('<span data-cid="' + pid +'">' + pname + '</span>');
			}else{
				_cate.find('span').eq(index).text(pname);
			}
		}
	})
	//提问页面提交按钮
	$('#ask button').on('click',function(){
		var question=$('#question');
		var count=getMessageLength($('#ask').find('#question').val());
		if(count==0){
			question.addClass('empty');
			setTimeout(function(){
				question.removeClass('empty');
			},800)
			return;
		}else if(count<5) {
			$('.title-tip').show().text('亲，请完善您的问题，问题描述的越清楚，越能收到更好的答案哦!');
			return;
		}else if(count>50){
			$('.title-tip').show().text('亲，您的提问超过了长城的长度，请精简您的提问哦！');
			return;
		}
		var cid=$('#ask').find('[name=cid]').val();
		if(cid==''){
			$('.selectCategory').trigger('click');
			return;
		}
		if($('.user').find('.userName').length==0){
			$('.login').trigger('click');
			return;
		}
		$('#ask').off().submit();
	})
	/*问题展示页面ask->show()*/
	$('.replyForm').on('submit',function(){return false;})
	$('.replyForm').find('button').on('click',function(){
		var count=getMessageLength($('.replyForm').find('textarea').val());
		// console.log(count);
		if(count==0){
			$('.replyForm').find('textarea').addClass('empty');
			setTimeout(function(){
				$('.replyForm').find('textarea').removeClass('empty');
			},800)
			return;
		}else if(count<5) {
			$('.title-tip').show().text('亲，回复不要太短哦!');
			return;
		}
		$('.title-tip').hide();
		if($('.user').find('.userName').length==0){
			$('.login').trigger('click');
			return;
		}
		$('.replyForm').off().submit();
	})
	/*采纳为满意答案*/
	$('.answerList').find('.adoption').children('a').on('click',function(){
		var aid=$(this).data('aid');
		var sid=$(this).data('sid');
		$.ajax({
			url:'?c=ask&m=adoption',
			data:{aid:aid,sid:sid},
			type:'post',
			success:function(data){
				if(data==1){
					success('操作成功!');
					window.location.reload();
				}else{
					error('出现错误，请重试!');
				}
			}
		})
	})
})