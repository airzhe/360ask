<?php require C('TPL_PUBLIC').'header.php';?>
</head>
<body>
	<?php require C('TPL_PUBLIC').'top.php';?>
	<!-- 模板结束 -->
	<div class="wrapper">
		<form action="?c=ask&amp;m=submit" method="post" id="ask">
			<h3>欢迎向360网友提问<s></s><span><i class="count">0</i>/50</span></h3>
			<p class="question" style="position:relative;"><input type="text" id="question" name="title" placeholder="请在这里简要描述您的问题" value="<?php if(isset($_data['question'])) echo $_data['question']?>"/><s class="hide"></s></p>
			<p><input type="hidden" name="cid"></p>
			<div class="q-box"><p class="title-tip hide">您的提问违反规则</p></div>
			<label>补充说明<span>（选填）</span></label>
			<div class="content">
				<p class="upload"><s></s>图片</p>
				<textarea name="content" id="" cols="30" rows="10" placeholder="在这里补充问题的详细信息，详细全面的问题往往有助于其他网友提供高质量的解答。"></textarea>
			</div>
			<p id="ask_category"><a href="javascript:void(0);" class="selectCategory">选择分类<s></s></a></p>
			<p class="submit"><label><input type="checkbox" name="is_hide">匿名</label><button>提交问题<s></s></button></p>
		</form>
	</div>
</body>
</html