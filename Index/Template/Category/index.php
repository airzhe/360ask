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
				<li><a href="?c=category&amp;cid=<?php echo $value['cid']?>"><?php echo $value['cname']?></a></li>
			<?php endforeach?>
		</ul>
	</div>
	<div id="breadcrumb">
		<ul class="crumb clearfix">
			<li><a href="">全部问题</a><i>&gt;</i></li>
			<?php foreach ($_data['path'] as $key => $v): ?>
			<li>
				<a href=""><?php echo $v['cname']?></a><s></s><i>&gt;</i>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
	<div class="wrapper cate_list clearfix">
		<div class="left">
			<div id="cate">
				<h3><?php echo $_data['current_cate']['cname']?></h3>
				<p>按分类查找</p>
				<ul class="clearfix">
					<?php foreach ($_data['child_cate'] as $k => $v): ?>
						<li><a href="?c=category&amp;cid=<?php echo $v['cid']?>"><?php echo $v['cname']?></a></li>
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
						<?php foreach ($_data['ask'] as $key => $v): ?>
							<tr>
							<td><a href="?c=ask&amp;m=show&amp;aid=<?php echo $v['aid']?>"><?php echo $v['title']?></a><a href="" class="cate">[<?php echo $_data['current_cate']['cname']?>]</a></td>
							<td><?php echo $v['re_count'] ?></td>
							<td><?php echo date('Y-m-d H:i',$v['time']) ?></td>
						</tr>
						<?php endforeach ?>
						
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