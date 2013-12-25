<?php if(!defined('APP_PATH'))die('error')?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php if(isset($_data['title'])) echo $_data['title']?></title>
	<link rel="stylesheet" href="<?php echo C('__PUBLIC__').'css/common.css'?>">
	<link rel="stylesheet" href="<?php echo C('TPL_PUBLIC').'css/style.css'?>">
	<?php if(isset($_data['css'])) echo $_data['css']?> <!--引入公共css-->
	<?php if(isset($_data['js'])) echo $_data['js']?>  <!--引入公共js-->
	<script src="<?php echo C('TPL_PUBLIC').'js/admin.js'?>"></script>