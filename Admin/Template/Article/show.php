<?php require C('__PUBLIC__').'header.php';?>
<body>
	<div class="container">
		<div class="page-header">
			<h1>文章列表页<small class="pull-right"><a href="?c=article&amp;m=add">添加</a></small></h1>
		</div>
		<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>标题</th>
				<th>内容</th>
				<th>操作</th>
			</tr>
			<?php foreach ($_data['data'] as  $v): ?>	
				<tr>
					<td><?php echo $v['id']?></td>
					<td><?php echo $v['title']?></td>
					<td><?php echo $v['content']?></td>
					<td>
						<a href="?c=article&amp;m=edit&amp;id=<?php echo $v['id']?>">编辑</a>
						<a href="?c=article&amp;m=del&amp;id=<?php echo $v['id']?>">删除</a>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</body>
</html>