<?php require C('__PUBLIC__').'header.php';?>
<body>
	<div class="container">
		<div class="page-header">
			<h1>文章编辑页面</h1>
		</div>
		<form action="" method="post">
			<div class="form-group">
				<label for="">标题</label>
				<input type="text" class="form-control" name="title" value="<?php echo $_data['title']?>">
			</div>
			<div class="form-group">
				<label for="">内容</label>
				<textarea name="content" cols="30" rows="10" class="form-control"><?php echo $_data['content']?></textarea>
			</div>
			<div class="form-group">
				<button class="btn btn-info">更新</button>
			</div>
		</form>
	</div>
</body>
</html>