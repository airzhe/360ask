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
	<div class="wrapper cate_list clearfix">
		<div class="left">
			<div id="cate">
				<h3><?php echo $_data['current_cate']['cname']?></h3>
				<p>按分类查找</p>
				<ul class="clearfix">
					<?php foreach ($_data['child_cate'] as $k => $v): ?>
						<li><a href=""><?php echo $v['cname']?></a></li>
					<?php endforeach ?>
				</ul>
				<p>按关键词查找</p>
				<form action="">
					<input type="text" name="keywords" />
					<button>搜索</button>
				</form>
			</div>
			<div class="list">
				<ul class="clearfix">
					<li class="selected"><a href="javascript:void(0)">待解决问题</a></li>
					<li><a href="">已解决</a></li>
				</ul>
				<div id="questions_list">
					<table>
						<tr>
							<th>标题</th>
							<th>回答数</th>
							<th>时间</th>
						</tr>
						<tr>
							<td><a href="">u盘写保护怎么去掉 </a><a href="" class="cate">[硬件]</a></td>
							<td>9</td>
							<td>5分钟前</td>
						</tr>
						<tr>
							<td><a href="">密码过期怎么办？</a><a href="" class="cate">[密码]</a></td>
							<td>8</td>
							<td>9分钟前</td>
						</tr>
						<tr>
							<td><a href="">哪里有安卓版的豪杰解霸软件</a><a href="" class="cate">[软件]</a></td>
							<td>5</td>
							<td>17分钟前</td>
						</tr>
						<tr>
							<td><a href="">真不知道百度是怎么想你敢和360作对</a><a href="" class="cate">[360产品]</a></td>
							<td>2</td>
							<td>24分钟前</td>
						</tr>
						<tr>
							<td><a href="">移动硬盘使用时电脑显示电量不足是...</a><a href="" class="cate">[硬盘]</a></td>
							<td>02</td>
							<td>40分钟前</td>
						</tr>
					</table>
					<!-- <p class="pages"><b>1</b><a href="?pn=1">2</a><a href="?pn=1" class="next">下一页&gt;</a></p> -->
				</div>
			</div>
		</div>
		<div class="right sidebar">
			<div class="user">loading...</div>
		</div>
	</div>
	<?php require C('TPL_PUBLIC').'footer.php';?>