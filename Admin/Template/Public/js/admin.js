$(document).ready(function(){
	var flag=0;
	$('#sidebar-collapse').find('i').click(function(){
		if(flag==0){
			$('.sidebar').css('width','42px');
			$('.main-content').css('margin-left','42px');
			$('#sidebar-shortcuts-large').hide();
			$('#sidebar-shortcuts-mini').show();
			$('.menu-text').hide();
			$(this).removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
			flag=1;
		}else if(flag==1){
			$('.sidebar').css('width','190px');
			$('.main-content').css('margin-left','190px');
			$('#sidebar-shortcuts-large').show();
			$('#sidebar-shortcuts-mini').hide();
			$('.menu-text').show();
			$(this).removeClass('fa-angle-double-right').addClass('fa-angle-double-left');
			flag=0;
		}
	})
})