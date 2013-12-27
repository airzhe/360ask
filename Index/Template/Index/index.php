<?php require C('TPL_PUBLIC').'header.php';?>
<script src="<?php echo C('TPL_PUBLIC').'js/index.js'?>"></script>
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
								<a href="c/cid=<?php echo $value['cid']?>"><?php echo $v['cname']?></a>
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
							<a href="c/cid=<?php echo $v['cid']?>"><?php echo $v['cname']?></a>
						<?php endforeach ?>
					</div>
				<?php endforeach?>				
			</div>
		</div>
		<div id="content">
			<div class="slide">
				<div class="content">
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_1.jpg'?>" width='270'height='190' />
						<div>
							<h3>4G时代到来，什么是4G <s></s></h3>
							<ul>
								<li><i></i><a href="">TD-LTE与FDD-LTE有何区别？</a></li>
								<li><i></i><a href="">4G技术会给我们生活带来哪些改变？</a></li>
								<li><i></i><a href="">4G套餐资费会不会很贵？</a></li>
								<li><i></i><a href="">世界上有哪些国家发射过探月卫星？</a></li>
							</ul>
						</div>
					</div>
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_2.jpg'?>" width='270'height='190' />
						<div>
							<h3>24G时代到来，什么是4G <s></s></h3>
							<ul>
								<li><i></i><a href="">TD-LTE与FDD-LTE有何区别？</a></li>
								<li><i></i><a href="">4G技术会给我们生活带来哪些改变？</a></li>
								<li><i></i><a href="">4G套餐资费会不会很贵？</a></li>
								<li><i></i><a href="">世界上有哪些国家发射过探月卫星？</a></li>
							</ul>
						</div>
					</div>
					<div class="item clearfix">
						<img src="<?php echo C('TPL_PUBLIC').'images/focus_3.jpg'?>" width='270'height='190' />
						<div>
							<h3>34G时代到来，什么是4G <s></s></h3>
							<ul>
								<li><i></i><a href="">TD-LTE与FDD-LTE有何区别？</a></li>
								<li><i></i><a href="">4G技术会给我们生活带来哪些改变？</a></li>
								<li><i></i><a href="">4G套餐资费会不会很贵？</a></li>
								<li><i></i><a href="">世界上有哪些国家发射过探月卫星？</a></li>
							</ul>
						</div>
					</div>
				</div>
				<ul class="slide-nav clearfix">
					<li class="selected">4g时代到来，什么是4G</li>
					<li>嫦娥三号将完成哪些任务</li>
					<li>曼德拉为何受到广泛尊敬</li>
				</ul>
			</div>
			<div id="questions">
				<h3><s></s> 待解决问题</h3>
				<a href="" class="more">更多>></a>
				<ul>
					<li><a href="">出国面试的时候需要准备什么证件么？</a><span>0回答</span></li>
					<li><a href="">在外企公司工作需要具备哪些能力<span>0回答</span></li>
					<li><a href="">dvr监控备份选择间h是什么意思<span>0回答</span></li>
					<li><a href="">,西普大陆狐狸面具怎么得？<span>0回答</span></li>
					<li><a href="">嫦娥三号指令长是谁</a><span>0回答</span></li>
					<li><a href="">步步高e50学习机宠物单词怎么下载</a><span>0回答</span></li>
					<li><a href="">神将世界的武魂为什么会没有了</a><span>0回答</span></li>
					<li><a href="">水平混凝土构件指哪些，梁和板都算吗</a>？<span>0回答</span></li>
					<li><a href="">九阳电热水壶的玻璃盖摔碎了怎么办</a><span>0回答</span></li>
					<li><a href="">电池不充电怎么回事</a><span>0回答</span></li>
					<li><a href="">123网址之家要多少资源</a><span>0回答</span></li>
					<li><a href="">卡布西游的主宠选啥</a><span>0回答</span></li>
					<li><a href="">有什么小说好看？</a><span>0回答</span></li>
					<li><a href="">安徽六安职称考试成绩单在哪里领取</a><span>0回答</span></li>
					<li><a href="">为什么说汕头是个改革失败的经济特区</a><span>0回答</span></li>
				</ul>
			</div>
		</div>
		<div class="sidebar">
			<div class="user">
			</div>
			<div>
				<img class="index_jifen" src="<?php echo C('TPL_PUBLIC').'images/index_jifen.jpg'?>" alt="">
			</div>
		</div>
	</div>
	<div id="cpoyright">
		<p>
			<a href="#">帮助</a>
			<a href="#">关于我们</a>
			<a href="#">用户反馈</a>
			<a href="3">侵权投诉</a>
			<a href="3">论坛</a>
			<br/>
			Copyright © 2013 Qihoo.Com All Rights Reserved 奇虎网    京公安网备11000000000006
		</p>
	</div>
</body>
</html>