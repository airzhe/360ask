<?php require C('TPL_PUBLIC').'header.php';?>
<script src="<?php echo C('TPL_PUBLIC')?>js/easypiechart.min.js"></script>
<script>
	$(document).ready(function(){
	// 百分比插件
	$('.chart').easyPieChart({
		barColor: '#d53f40'
    });
    $('.del_ask').on('click',function(){
    	if(!confirm('确定要执行该操作么？'))
    		return;
    	var aid=$(this).data('aid');
    	var self=$(this);
    	$.ajax({
    		url:'?c=member&m=del_ask',
    		type:'get',
    		data:{aid:aid},
    		success:function(data){
    			if(data==1){
    				self.parents('tr').remove();
    			}else{
    				error('出错了，请重试。');
    			}
    		}
    	})
    })
})
</script>
</head>
<body>

	<?php require C('TPL_PUBLIC').'top.php';?>
	<div id="navigate">
		<ul class="menu clearfix">
			<li><a href="#" class="current">问答首页</a><i></i></li>
			<li id="mav_category"><a href="#">问题库</a><i></i></li>
			<li><a href="?c=ask&amp;m=question">提问</a><i></i></li>
			<li><a href="#">管理团</a><i></i></li>
			<li><a href="#">积分商城</a></li>
		</ul>
		<a href="#" class="help">• 帮助</a>
	</div>
	<div class="wrapper clearfix" id="userCenter">
		<div class="left">
			<div class='avatar'>
				<img src="<?php echo $_data['me']['avatar']?>" alt="" />
				<a class="changAvatar" href="?c=member&amp;m=avatar">更换头像</a>
				<p><?php echo $_SESSION['uname']?></p>
			</div>
			<ul>
				<li class="current" data-href='achievement'><a href="javascript:void(0);"><s></s>我的成就</a></li>
				<li data-href='question'><a href="javascript:void(0);"><s></s>我的提问</a></li>
				<li data-href='answer'><a href="javascript:void(0);"><s></s>我的回答</a></li>
				<!-- <li data-href='message'><a href="javascript:void(0);"><s></s>我的消息</a></li> -->
			</ul>
		</div>
		<div class="right">
			<img class="loading" src="<?php echo C('TPL_PUBLIC')?>images/ajax-loader.gif"/>
			<h3>我的成就</h3>
			<div class="content">
				<!-- 我的成就 -->
				<ul class="achievement clearfix">
					<li>
						<s></s>
						<span>回答数<br /><i><?php echo $_data['me']['answer_num'] ?></i></span>
					</li>
					<li>
						<s class="chart" data-percent="<?php echo $_data['me']['ratio'] ?>" data-size="50"></s>
						<span>采纳率<br /><i><?php echo $_data['me']['ratio'] ?></i></span>
					</li>
					<li>
						<s></s>
						<span>提问数<br /><i><?php echo $_data['me']['ask_num'] ?></i></span>
					</li>
				</ul>
				<!-- 我的成就 -->
				<!-- 我的提问 -->
				<div class="question">
					<p>
						<a href="" class="current">待解决问题</a>
						<a href="">已解决的问题</a>
					</p>
					<table>
						<tr><th>标题</th><th>时间</th><th>浏览量</th></tr>
						<?php foreach ($_data['ask'] as $key => $v): ?>
							<tr>
							<td><a href="?c=ask&amp;m=show&amp;aid=<?php echo $v['aid']?>" target="_blank"><?php echo $v['title']?></a></td>
							<td><?php echo date('Y-m-d H:i',$v['time']) ?></td>
							<td><?php echo $v['hits'] ?></td>
							<td><a class="del_ask" data-aid="<?php echo $v['aid']?>" href="javascript:void(0);">×</a></td>
						</tr>
						<?php endforeach ?>
					</table>
				</div>
				<!-- 我的提问 -->
				<!-- 我的回答 -->
				<table class="answer">
					<tr><th>标题</th><th>时间</th><th>浏览量</th></tr>
					<?php foreach ($_data['answer'] as $key => $v): ?>
							<tr>
							<td><a href="?c=ask&amp;m=show&amp;aid=<?php echo $v['aid']?>" title="<?php echo $v['content']?>"  target="_blank"><?php echo mb_substr($v['content'],0,30,'utf8').'...'?></a></td>
							<td><?php echo date('Y-m-d H:i',$v['time']) ?></td>
						</tr>
					<?php endforeach ?>
				</table>
				<!-- 我的回答 -->
				<!-- 我的消息 -->
				<!-- <table class="message">
					<tr><th>标题</th><th>时间</th></tr>
					<tr>
						<td><a href="">message</a></td>
						<td>2012-12-5</td>
					</tr>
					<tr>
						<td><a href="">航二级菜单jquery下拉菜单_51模板集 - 系统开发</a></td>
						<td>2011-12-5</td>
					</tr>
					<tr>
						<td><a href="">二级菜单jquery下拉菜单_51模板集 - 系统开发</a></td>
						<td>2013-12-5</td>
					</tr>
				</table> -->
				<!-- 我的消息 -->
			</div>
		</div>
	</div>
</body>
</html>