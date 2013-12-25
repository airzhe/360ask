<?php require C('__PUBLIC__').'header.php';?>
<body>
	<div class="container">
		<div class="page-header">
			<h1>文章添加页面</h1>
		</div>
		<form action="?c=article&amp;m=add" method="post">
			<div class="form-group">
				<label for="">标题</label>
				<input type="text" class="form-control" name="title">
			</div>
			<div class="form-group">
				<label for="">内容</label>
				<textarea name="content" cols="30" rows="10" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-info">添加</button>
			</div>
		</form>
	</div>
</body>
</html>