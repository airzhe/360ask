<?php if(!defined('APP_PATH'))die('error')?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php if(isset($_data['title'])) echo $_data['title']?></title>
	<link rel="stylesheet" href="<?php echo C('TPL_PUBLIC').'css/style.css'?>">
	<?php if(isset($_data['js'])) echo $_data['js']?>  <!--引入公共js-->
	<script>
		var userStatusPath="./?c=user&m=status";
		var loginPath="./?c=user&m=login";
		var registPath="./?c=user&m=regist";
		var loginVerifyPath="<?php echo C('TPL_PUBLIC').'js/verify_login.js'?>";
		var registVerifyPath="<?php echo C('TPL_PUBLIC').'js/verify_register.js'?>";
	</script>
	<script src="<?php echo C('TPL_PUBLIC').'js/common.js'?>"></script>
	<script src="<?php echo C('TPL_PUBLIC').'js/index.js'?>"></script>	