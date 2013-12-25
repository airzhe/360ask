<?php 
/**
 * 格式化输出数组
 */
function p($arr){
	echo '<pre>'.print_r($arr,true).'</pre>';
}
/**
 * 自动加载类函数
 */
function __autoload($class){
	$classFile=$class.'.class.php';
	//引入类文件
	require_cache(array(RUN_PATH.'Core/'.$classFile,CONTROLLER_PATH.$classFile));
}
/**
 * 在多目录查找并加载文件函数
 */
function require_cache($file){
	//这一句是为了加载单文件而写
	$file=is_array($file)?$file:array($file);
	static $_file=array();
	foreach ($file as $f) {
		$name=md5($f);
		//如果文件已经加载过就返回
		if(isset($_file[$name])) return true;
		if(is_file($f)){
			require($f);
			$_file[$name]=$f;
			//文件加载成功就返回
			return true;
		}
	}
}
/**
 * C函数，读取配置文件，参数为空时，返回所有配置项
 */
function C($name=null,$value=null){
	static $_config=array();
	if(is_null($value)){
		if(is_null($name)){
			//返回所有配置项目
			return $_config;
		}else{
			if(is_string($name)){
				//返单条配置
				return $_config[$name];
			}elseif(is_array($name)){
				//合并配置项
				$_config=array_merge($_config,$name);
			}
		}
	}else{
		//更改配置项
		$_config[$name]=$value;
	}
}
function error($msg,$url=null){
	$url=is_null($url)?"window.history.go(-1)":"location.href='{$url}'";
	$html=<<<str
<div style="border:2px solid yellow;color:red;"><h2>:( $msg</h2></div>
	<script>
		setTimeout(function(){
			{$url}
		},2000)
</script>
str;
	echo $html;
	die();
}
/**
 * load_file加载目标目录下的$files数组里的文件
 * @param $files array
 * @param type int 为false时候返回文件路径 为true时返回网页路径
 */
function load_file($files,$path,$type=false){
	$path=RUN_PATH.str_replace('.','/',$path);
	if(!is_dir($path)){error('路径错误');}
	$arr=glob_file($path);
	// p($arr);die;
	$_files='';
	foreach ($files as $v) {
		foreach ($arr as $f) {
			if(strrpos($f, $v)!==false){
				if($type){ 
					$f=str_replace($_SERVER['DOCUMENT_ROOT'],'http://'.$_SERVER['HTTP_HOST'],$f);
					switch ($type) {
						case 'css':
						$_files.='<link rel="stylesheet" href="'.$f.'" />'."\n";
						break;
						case 'js':
						$_files.='<script src="'.$f.'"></script>'."\n";
						break;
					}
				}else{
					$_files[]=$f;
				}
			}
			continue;
		}
	}
	return $_files;
}
/**
 * glob_file 递归取得指定路径下的文件
 * @param return array;
 */
function glob_file($path){
	static $_f=array();
	$arr=glob($path.'/*');
	foreach ($arr as $v) {
		if(is_file($v)){
			$_f[]=$v;
		}else{
			glob_file($v);
		}
	}
	return $_f;
}
/**
 * import 加载扩展类
 */
function import($path){
	$file=RUN_PATH.'Extend/'.str_replace('.','/',$path).'.class.php';
	include $file;
}