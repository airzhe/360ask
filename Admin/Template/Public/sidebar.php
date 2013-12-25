<?php if(!defined('APP_PATH'))die('error')?>
<div class="sidebar">
	<div id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-small btn-success">
				<i class="fa fa-signal"></i>
			</button>

			<button class="btn btn-small btn-info">
				<i class="fa fa-pencil"></i>
			</button>

			<button class="btn btn-small btn-warning">
				<i class="fa fa-group"></i>
			</button>

			<button class="btn btn-small btn-danger">
				<i class="fa fa-cogs"></i>
			</button>
		</div>

		<div id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div>
	<ul class="nav">
		<li class="active"><a href="?c=category"><i class="fa fa-list"></i> <span class="menu-text">分类管理</span></a></li>
		<li><a href=""><i class="fa fa-gears"></i> <span class="menu-text">系统设置<span></a></li>
	</ul>
	<div  id="sidebar-collapse">
		<i class="fa fa-angle-double-left"></i>
	</div>
</div>