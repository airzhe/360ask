<?php require C('TPL_PUBLIC').'header.php';?>
<script src="<?php echo C('TPL_PUBLIC').'js/index.js'?>"></script>
</head>
<body>
	<?php require C('TPL_PUBLIC').'top.php';?>
	<!-- 模板结束 -->
	<div class="wrapper">
		<form action="" id="ask">
			<h3>欢迎向360网友提问<s></s><span><i class="count">0</i>/50</span></h3>
			<p class="question" style="position:relative;"><input type="text" id="question" placeholder="请在这里简要描述您的问题" value="<?php if(isset($_data['question'])) echo $_data['question']?>"/><s class="hide"></s></p>
			<label>补充说明<span>（选填）</span></label>
			<div class="content">
				<p class="upload"><s></s>图片</p>
				<textarea name="" id="" cols="30" rows="10">在这里补充问题的详细信息，详细全面的问题往往有助于其他网友提供高质量的解答。</textarea>
			</div>
			<a>选择分类<s></s></a>
			<p class="submit"><button>提交问题<s></s></button></p>
		</form>
	</div>
</body>
</html