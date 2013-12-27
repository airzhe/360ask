$.extend({
	"modal": function (options) {
	 		var _default = {
	 			top:'',
	 			width: 400, 
	 			height:'',
	 			title: '请确认', 
	 			body: '加载中...', 
	 			footer: '<button>确定</button> <button>取消</button>',
	 			c_type:1,
	 			callback: function (){}
	 		};
	 		var opt = $.extend(_default, options);

	 		$("div.modal").remove();

			//创建弹出框
			var div='';
			div+='<div class="modal">';
			div+='<div class="modal_title"><h2>'+ opt['title'] +'</h2><i class="close">×</i></div>';
			div+='<div class="modal_body">'+ opt['body'] +'</div>';
			if(opt.footer){
				div+='<div class="modal_footer">'+ opt['footer'] +'</div>';
			}
			div+='</div>';
			div+='<div class="modal_bg"></div>';
			$(div).appendTo("body");

			//设置弹出框和背景遮照样式
			var modal=$('div.modal');
			modal.css({width:opt['width'],height:opt['height']});
			var modal_bg=$('.modal_bg');
			opt.callback(modal);
			//关闭弹出框
			var close_btn=modal.find('.close'); 
			close_btn.on('click',function(){
				modal.fadeOut('fast',function(){
					$(this).remove();
					$(".modal_bg").remove();
				})
			})
			//关闭的方式
			if(opt.c_type==0){
				$(document).on('keydown',function(e){
					if(e.which===27)
						close_btn.trigger('click');
				})
				modal_bg.on('click',function(){
					close_btn.trigger('click')
				})
			}
			position();
			//改变窗口大小触发事件
			window.onresize=function(){
				position();
			}
		//设置弹出框的位置
		function position(){
			var pos=get_pos(modal);
			modal.css(
			{
				left: pos[0],
				top: pos[1]
			});
			modal_bg.width($(document).width()).height($(document).height());
		}
		//获得对象在页面中心的位置
		function get_pos(obj){
		 var pos = [];//位置
		 pos[0] = ($(window).width() - obj.width()) / 2;
		 pos[1] = opt['top']?opt['top']:($(window).height() - obj.height()) / 2 - 50;
		 return pos;
		}
	}
});