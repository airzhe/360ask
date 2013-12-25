<?php
class Dir{
	/**
	 * 递归遍历删除目录
	 * @param string $dir目录名称
	 * @return bool
	 */
	static public function rmdir_d($dir){
		if(!is_dir($dir)) return;
		$files=glob($dir.'/*');
		// print_r($files);exit();
		foreach($files as $f){
			is_dir($f)?self::rmdir_d($f):unlink($f);
		}
		return rmdir($dir);
	}

	/**
	 * 递归拷贝目录
	 * @param string $old 
	 * @param string $new
	 * @return bool
	 */
	static public function copy_d($old,$new){
		if(!is_dir($old)) return;
		is_dir($new) or mkdir($new,0777,true);
		$files=glob($old.'/*');
		foreach ($files as $f) {
			$to=$new.'/'.basename($f);
			is_dir($f)?self::copy_d($f,$to):copy($f,$to);
		}
		return true;
	}

	/**
	 * 利用系统函move移动目录
	 * @param string $old
	 * @param string $new
	 * @return bool
	 */
	static public function move_d($old,$new){
		if(!is_dir($old))return;
		$path=pathinfo($new);
		$root=$path['dirname'];
		is_dir($root) or mkdir($root,0777,true);
		return rename($old,$new);
	}

	/**
	 * 递归移动目录
	 * @param string $old
	 * @param string $new
	 * @return bool
	 */
	static public function move_d2($old,$new){
		if(!is_dir($old)) return;
		is_dir($new) or mkdir($new,0777,true);
		$files=glob($old.'/*');
		foreach ($files as $f) {
			$to=$new.'/'.basename($f);
			is_dir($f)?self::move_d($f,$to):rename($f,$to);
		}
		return rmdir($old);
	}
}