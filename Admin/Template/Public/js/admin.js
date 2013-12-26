/*设置cookie的值*/
function addCookie(name,value,expiresHours){ 
	var cookieString=name+"="+escape(value); 
	//判断是否设置过期时间 
	if(expiresHours>0){ 
		var date=new Date(); 
		date.setTime(date.getTime+expiresHours*3600*1000); 
		cookieString=cookieString+"; expires="+date.toGMTString(); 
	} 
	document.cookie=cookieString; 
}
/*获得cookie的值*/
function getCookie(name){ 
	var strCookie=document.cookie; 
	var arrCookie=strCookie.split("; "); 
	for(var i=0;i<arrCookie.length;i++){ 
		var arr=arrCookie[i].split("="); 
		if(arr[0]==name)return arr[1]; 
	} 
	return ""; 
}
$(document).ready(function(){
	switch_ico=$('#sidebar-collapse').find('i')
	/*点击切换开关*/
	switch_ico.click(function(){	
		if(getCookie('_sidebar')==0){
			addCookie('_sidebar','1',3600);
		}else{
			addCookie('_sidebar','0',3600);
		}
		_switch();
	});
	/*页面载如判断并切换样式*/
	_switch();
	function _switch(){
		if(getCookie('_sidebar')==0){
			$('.sidebar').css('width','42px');
			$('.main-content').css('margin-left','42px');
			$('#sidebar-shortcuts-large').hide();
			$('#sidebar-shortcuts-mini').show();
			$('.menu-text').hide();
			switch_ico.removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
		}else if(getCookie('_sidebar')==1){
			$('.sidebar').css('width','190px');
			$('.main-content').css('margin-left','190px');
			$('#sidebar-shortcuts-large').show();
			$('#sidebar-shortcuts-mini').hide();
			$('.menu-text').show();
			switch_ico.removeClass('fa-angle-double-right').addClass('fa-angle-double-left');
		}
	}
})