<div class="header">
	<div id="search" class="clearfix">
		<h1 class="logo"><a href="./">360问答<s></s></a></h1>
		<form action="?c=ask&amp;m=question" method="post">
			<input type="text" name="q" value="<?php if(isset($_data['question'])) echo $_data['question']?>"/>
			<button class="search">搜索答案<s></s></button>
			<button class="ask"><s></s>提问</button>
		</form>
		<div class='user'></div>
	</div>
</div>
