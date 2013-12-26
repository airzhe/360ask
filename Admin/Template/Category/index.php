<?php require C('TPL_PUBLIC').'header.php';?>
<script>
	$(function(){
		function success(msg){
			alert(msg);
		}
		function error(msg){
			alert(msg);
		}
		/*隐藏没有子元素的分类前的图标*/
		$('tr:gt(0)').each(function(){

		})
		/*点击展开、关闭树状结构*/
		$('#category').on('click','.switch',function(){
			if($(this).hasClass('fa-minus-square-o')){
				$(this).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
			}else{
				$(this).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
			}
			var _tr=$(this).parents('tr')
			var cls=_tr.attr('class');
			_tr.nextUntil('.' + cls).toggle();

			// var tr=$(this).parents('tr')
			// var level=parseInt(/\d+/.exec(tr.attr('class')))+1;
			// tr.nextAll('.level_' + level).toggle();

		})
		/*异步修改数据*/
		$('[name=sort],[name=cname]').focus(function(){
			var oldData=$(this).val();
			$(this).off('blur').on('blur',function(){
				//验证文本框内容是否为改变，或为空。
				var newData=$.trim($(this).val());
				if(newData==oldData || newData==''){
					$(this).html(oldData);
					return;
				}
				//验证文本框内容是否为数字
				var name=$(this).attr('name');
				if(name=='sort'){
					if(!/^\d+$/.test(newData)){
						error('内容只能是数字');
						return;
					}
				}
				//取得主键id，并异步修改数据库字段
				var cid=$(this).parents('tr').data('cid');
				$.post('?c=category&m=ajax_edit', {cid:cid,arg:name+'@=@'+newData}, function(data) {
					if(data==1){
						success('操作成功！');
						$(this).html(newData);
					}else{
						error('操作失败！');
						$(this).html(oldData);
					}
				})
			})
		})
		/*异步删除数据*/
		$('.del').on('click',function(e){
			e.preventDefault();
			var _tr=$(this).parents('tr')
			var cid=_tr.data('cid');
			$.ajax({
				url:'?c=category&m=del',
				type:'get',
				data:{cid:cid},
				success:function(data){
					if(data==1){
						_tr.fadeOut(function(){
							$(this).remove();
						});
					}else{
						error('删除失败');
					}
				}
			})
		})
	})
</script>
</head>
<body style="position:relative;">
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
				<a href="?c=category&amp;m=add" class="btn btn-success" id="addCate">新增</a>
				<table class="table" id="category">
					<tr>
						<th>折叠</th>
						<th>排序</th>
						<th colspan="2">名称</th>
					</tr>
					<?php foreach ($_data['category'] as $v): ?>
						<tr class="level_<?php echo $v['level']?>" data-cid="<?php echo $v['cid']?>">
							<td><i class="fa fa-plus-square-o switch"></i></td>
							<td><input type="text" value="<?php echo $v['sort']?>" name="sort"></td>
							<td><?php echo $v['html']?> <input type="text" value="<?php echo $v['cname']?>" name="cname"> <a href="?c=category&amp;m=add&amp;pid=<?php echo $v['cid']?>"><i class="fa fa-plus-circle"></i></a></td>
							<td><a href="?c=category&amp;m=edit&amp;cid=<?php echo $v['cid']?>">编辑</a> <a href="javascript:void(0)" class="del">删除</a></td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
			<?php require C('TPL_PUBLIC').'footer.php';?>
		</div>
	</div>
</body>
</html>