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
/**
 * $string 明文或密文
 * $operation 加密ENCODE或解密DECODE
 * $key 密钥
 * $expiry 密钥有效期
 */ 
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
	$ckey_length = 4;
	
    // 密匙
    // $GLOBALS['discuz_auth_key'] 这里可以根据自己的需要修改
	$key = md5($key ? $key : 'houdunang'); 
	
    // 密匙a会参与加解密
	$keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
    // 产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
    // 核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
        // substr($result, 0, 10) == 0 验证数据有效性
        // substr($result, 0, 10) - time() > 0 验证数据有效性
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
        // 验证数据有效性，请看未加密明文的格式
		if(substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			if(substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
			{
				return substr($result, 26);
			}else{
				return md5('Timeout');
			}
		} else {
			return '';
		}
	} else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}