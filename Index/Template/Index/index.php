<?php require C('TPL_PUBLIC').'header.php';?>
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
			<li><a href="c=category&amp;cid=<?php echo $value['cid']?>"><?php echo $value['cname']?></a></li>
		<?php endforeach?>
		</ul>
	</div>
	<div class="wrapper clearfix">
		<div id="category">
			<div class="title">所有问题分类</div>
			<div class="content">
				<ul>
					<?php array_pop($_data['category']);foreach ($_data['category'] as $value):?>
						<li>
							<h4><?php echo $value['cname']?></h4>
								<?php $i=0;foreach ($value['child'] as $v): 
									$i++;
									if($i>3) break;
								?>
								<a href="?c=category&amp;cid=<?php echo $value['cid']?>"><?php echo $v['cname']?></a>
								<s></s>
							<?php endforeach ?>
						</li>
					<?php endforeach?>
				</ul>
			</div>
			<div class="sub">
				<?php foreach ($_data['category'] as $value):?>
					<div class="more hide">
							<?php $i=0;foreach ($value['child'] as $v): 
								$i++;
								if($i<4) continue;
							?>
							<a href="c=category&amp;cid=<?php echo $v['cid']?>"><?php echo $v['cname']?></a>
						<?php endforeach ?>
					</div>
				<?php endforeach?>				
			</div>
		</div>
		<div id="content">
			<div class="slide">
				<div class="content">
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_1.png'?>" width='270'height='190' />
						<div>
							<h3>如何在网上抢火车票？ <s></s></h3>
							<ul>
								<li><i></i><a href="">购买火车票要注意哪些事项？</a></li>
								<li><i></i><a href="">今年春运火车票退票费怎么算？</a></li>
								<li><i></i><a href="">无座火车票坐车怎么办？</a></li>
								<li><i></i><a href="">火车车厢一般哪些号靠窗？？</a></li>
							</ul>
						</div>
					</div>
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_2.jpg'?>" width='270'height='190' />
						<div>
							<h3>宝宝疫苗接种注意事项 <s></s></h3>
							<ul>
								<li><i></i><a href="">什么是疫苗接种？</a></li>
								<li><i></i><a href="">儿童出生后要接种哪些疫苗？</a></li>
								<li><i></i><a href="">什么是偶合症，偶合症能避免吗？</a></li>
								<li><i></i><a href="">疫苗事件频发，疫苗还打不打呢？</a></li>
							</ul>
						</div>
					</div>
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_3.jpg'?>" width='270'height='190' />
						<div>
							<h3>2013年度十大网络用语 <s></s></h3>
							<ul>
								<li><i></i><a href="">什么是土豪？</a></li>
								<li><i></i><a href="">女汉子是怎么定义的？</a></li>
								<li><i></i><a href="">”待我长发及腰“有什么典故？</a></li>
								<li><i></i><a href="">我和我的小伙伴们都惊呆了出自哪？</a></li>
							</ul>
						</div>
					</div>
				</div>
				<ul class="slide-nav clearfix">
					<li class="selected">如何在网上抢火车票？</li>
					<li>宝宝疫苗接种注意事项</li>
					<li>2013年度十大网络用语？</li>
				</ul>
			</div>
			<div id="questions">
				<h3><s></s> 待解决问题</h3>
				<a href="?c=category" class="more">更多>></a>
				<ul>
				<?php foreach ($_data['ask'] as $key => $v): ?>
					<li><a href="?c=ask&amp;m=show&amp;aid=<?php echo $v['aid']?>"><?php echo $v['title']?></a><span>0回答</span></li>
				<?php endforeach ?>
				</ul>
			</div>
		</div>
		<div class="sidebar">
			<div class="user">
			数据加载中...
			</div>
			<div>
				<img class="index_jifen" src="<?php echo C('TPL_PUBLIC').'images/index_jifen.jpg'?>" alt="">
			</div>
		</div>
	</div>
<?php require C('TPL_PUBLIC').'footer.php';?>