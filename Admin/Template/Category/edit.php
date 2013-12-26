<?php require C('TPL_PUBLIC').'header.php';?>
<style>

	.category_edit label{font-family: 'microsoft yahei';color:#404040;}
	.category_edit .form-control{border-radius: 0;width:390px;}
	.category_edit .btn{border-radius: 0;}
	.check-tips{font-size: 12px;color:#aaa;margin-left:7px;}
	.main_title{padding-bottom: 20px;}
	.main_title h2{color:#445566;font-weight: 400;font-size: 20px;}
</style>
</head>
<body>
	<?php require C('TPL_PUBLIC').'top.php';?>
	<div class="wrapper">
	<?php require C('TPL_PUBLIC').'sidebar.php';?>
	<div class="main-content">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"></i> 
				<a href="#">Home</a>
				<span class="divider">
					<i class="icon-angle-right arrow-icon"></i>
				</span>
			</li>
			<li class="active">Calendar</li>
		</ul>
		<div class="page-content">
			<div class="main_title">
				<h2><?php echo $_data['title']?></h2>
			</div>
			<form action="?c=category&amp;m=edit" class="category_edit">
				<div class="form-group">
					<label >上级分类</label>
					<input type="text" class="form-control"
					<?php if (isset($_GET['cid'])): ?>
						value="<?php echo $_GET['cid'];?>"
					<?php else: ?>
						value='无' disabled
					<?php endif ?>
					>
				</div>
				
				<div class="form-group">
					<label>分类名称<span class="check-tips">（名称不能为空）</span></label>
					<input type="hidden" name="cid">
					<input type="text" class="form-control">
				</div>
				<button  class="btn btn-info">确定</button>&nbsp;<a href="?c=category" class="btn btn-info">返回</a>
			</form>
		</div>
		<?php require C('TPL_PUBLIC').'footer.php';?>
	</div>
	</div>
</body>
</html>