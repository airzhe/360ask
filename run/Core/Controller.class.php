<?php
/**
 * 公共类
 */
class Controller{
	private $data=array();
	/**
	 * 模板传参数
	 * @param $name为数组键名
	 * @param $value为对应的键值
	 */
	public function assign($name,$value){
		$this->data[$name]=$value;
	}
	//模板调用函数
	public function display($tpl){
		$_data=$this->data;
		if(is_file(TEMPLATE_PATH.$tpl)){
			include TEMPLATE_PATH.$tpl;
		}else{
			$this->error('模板文件不存在');
		}
	}
	/**
	 * 操作成功提示并跳转函数
	 * @param string $msg 提示信息
	 * @param string $url 要跳转的地址，默认浏览器后退。
	 */
	public function success($msg,$url=null){
		$url=$url?"location.href='{$url}'":"window.history.go(-1)";
		$html=<<<str
		<div style="background:#dff0d8;color:#468847;border:1px solid #d6e9c6;padding:20px;"><h2>:) $msg</h2></div>
<script>
	setTimeout(function(){
		{$url}
	},2000)
</script>
str;
		echo $html;
	}
	/**
	 * 操作失败提示并跳转函数
	 * @param string $msg 提示信息
	 * @param string $url 要跳转的地址，默认浏览器后退。
	 */
	public function error($msg,$url=null){
		$url=is_null($url)?"window.history.go(-1)":"location.href='{$url}'";
		$html=<<<str
<div style="background:#f2dede;color:#b94a48;border:1px solid #eed3d7;padding:20px;"><h2>:( $msg</h2></div>
	<script>
		setTimeout(function(){
			{$url}
		},2000)
</script>
str;
		echo $html;
		die();
	}
}