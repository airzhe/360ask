<?php
/**
 * 后台公共控制器
 */
class CommonController extends Controller{
	public function __construct(){
		session_name(C('SESSION_NAME'));
		//加载公共css样式,js库
		$js=array('jquery-1.10.2.min.js','jquery.validate.js','modal.js');
		$_js=load_file($js,'Extend.Org.js','js');
		$this->assign('js',$_js);
	}
}