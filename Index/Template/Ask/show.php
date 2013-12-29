<?php require C('TPL_PUBLIC').'header.php';?>
<script>
	$(document).ready(function(){
		if($('.answer').length==0){
			$('.question').append('<s></s>');
			$('.question').css('padding-left','60px');
		}
	})
</script>
</head>
<body>
	<?php require C('TPL_PUBLIC').'top.php';?>
	<div id="navigate">
		<ul class="menu clearfix">
			<li><a href="#" class="current">问答首页</a><i></i></li>
			<li id="mav_category"><a href="#">问题库<s></s></a><i></i></li>
			<li><a href="?c=ask&amp;m=question">提问</a><i></i></li>
			<li><a href="#">管理团</a><i></i></li>
			<li><a href="#">积分商城</a></li>
		</ul>
		<a href="#" class="help">• 帮助</a>
		<ul class="category hide">
			<?php foreach ($_data['category'] as $value):?>
				<li><a href="c/cid=<?php echo $value['cid']?>"><?php echo $value['cname']?></a></li>
			<?php endforeach?>
		</ul>
	</div>
	<div id="breadcrumb">
		<ul class="crumb clearfix">
			<li><a href="">全部问题</a><i>&gt;</i></li>
			<li>
				<a href="">生活</a><s></s><i>&gt;</i>
				<ul class="hide">
					<li><a href="">电脑/网络</a></li>
					<li><a href="">笔记本电脑</a></li>
					<li><a href="">互联网</a></li>
					<li><a href="">操作系统</a></li>
					<li><a href="">手机/数码</a></li>
				</ul>
			</li>
			<li>
				<a href="">生活知识</a><s></s>
				<ul class="hide">
					<li><a href="">电脑/网络</a></li>
					<li><a href="">笔记本电脑</a></li>
					<li><a href="">互联网</a></li>
					<li><a href="">操作系统</a></li>
					<li><a href="">手机/数码</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="wrapper">
		<div class="view_wrapper clearfix">
			<div class="view_content">
				<div class="question">
					<h1><?php echo $_data['ask']['title']?></h1>
					<p class="clearfix"><span class="left"><?php echo $_data['ask']['uname']?><i>|</i>被浏览<?php echo $_data['ask']['hits']?>次</span>
						<span class="right">
							<?php if ($_data['ask']['uid']==$_data['s_uid']): ?>
								<a href=""><span>删除</span></a>
							<?php else: ?>
								<a href=""><span>检举</span></a>
							<?php endif ?><i>|</i><?php echo date('Y-m-d H:i',$_data['ask']['time'])?>
						</span>
					</p>
				</div>
				<?php if ($_data['ask']['sid']): ?>
					<div class="adopt clearfix">
						<s></s>
						<div class="answer">
							<h4 class="left">满意回答</h4>
							<span class="right"><a href=""><span>检举</span></a><i>|</i><?php echo date('Y-m-d H:i',$_data['ado']['time'])?></span></p>
							<div><?php echo $_data['ado']['content']?></div>
							<p class="button"><button><i></i><b>0</b><span>有帮助</span></button><button><i></i><b>0</b><span>无帮助</span></button></p>
						</div>
						<div class="author clearfix"> 
							<?php if (!$_data['ado']['is_hide']): ?>
								<img src="<?php echo C('TPL_PUBLIC')?>images/avatar.jpg" width="35" class="left" />
								<span><?php echo $_data['ado']['uname']?></span><br/>
								采纳率5%;
							<?php else: ?>
								<img src="<?php echo C('TPL_PUBLIC')?>images/avatar.jpg" width="35" class="left" />
								<span>匿名</span><br/>
							<?php endif ?>
						</div>
					</div>
				<?php endif ?>
				<?php if ($_data['ask']['uid']!=$_data['s_uid'] and $_data['ask']['sid']==0): ?>
					<div>
						<form action="?c=ask&amp;m=replay" class="replyForm" method="post">
							<p><b>我来回答</b></p>
							<div class="content">
								<p class="upload"><s></s>图片</p>
								<textarea name="content" cols="30" rows="10" placeholder="在这里补充问题的详细信息，详细全面的问题往往有助于其他网友提供高质量的解答。"></textarea>
							</div>
							<input type="hidden" name="aid" value="<?php echo $_GET['aid']?>">
							<div class="q-box"><p class="title-tip hide">您的回复违反规则</p></div>
							<p class="submit clearfix"><span><input type="checkbox" name="is_hide" id="" />匿名</span><button>提交问题</button></p>
						</form>
					</div>
				<?php endif ?>
				<?php if ($_data['answer_count']): ?>
					<div class="answerList">
						<h4>
							<?php if (!$_data['ask']['sid']): ?>
								全部回答
							<?php else: ?>
								其他回答
							<?php endif ?>
							(<?php echo $_data['answer_count']?>)
						</h4>
						<ul>
							<?php foreach ($_data['answer'] as $v): ?>
								<li>
									<p class="meta"><span><?php echo $v['uname']?></span><i><?php echo date('Y-m-d H:i',$v['time'])?></i></p>
									<p class="content"><?php echo nl2br($v['content'])?></p>
									<?php if (!$_data['ask']['sid']): ?>
										<p class="adoption"><a href="javascript:void(0);" data-aid="<?php echo $_GET['aid']?>" data-sid="<?php echo $v['sid']?>">采纳为满意答案</a></p>
									<?php endif ?>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>
				<div class="share">
					<p>
						分享到：
						<span class="sina" title="新浪">新浪<s></s></span>
						<span class="qq" title="QQ空间">QQ<s></s></span>
						<span class="renren" title="人人网">人人<s></s></span>
					</p>
				</div>
			</div>
			<div class="view_sidebar">
				<h4>今日网友热议</h4>
				<p><a href="">什么是4G?</a></p>
				<p class="describe">
					<a href="">12月5日三家移动运营商一起获得首批4G牌照，4G时代到来，4G究竟是什么？4G将给我们生活带来哪些改变？</a>
				</p>
			</div>
		</div>
	</div>
	<?php require C('TPL_PUBLIC').'footer.php';?>