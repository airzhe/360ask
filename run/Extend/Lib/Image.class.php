<?php
/*缩略图处理
1 打开原图   缩略的画布  
2 缩略的方式  1 画布不动，缩放原图  2 宽度固定 缩略画布高度 
*/
class Image{
	public $thumb_w;//缩放的宽度
	public $thumb_h;//缩放的高度
	public $thumb_type=1;//缩放的类型
	public function __construct(){
	}
	//1.jpg   1_thumb.jpg
	public function thumb($file,$thumb_file=NULL,$thumb_w=200,$thumb_h=200,$thumb_type=1){
		$this->thumb_w=$thumb_w;
		$this->thumb_h=$thumb_h;
		$this->thumb_type=$thumb_type;
		//验证图片文件
		if(!$this->check_file($file)){
			return false;
		}
		$img_info =getimagesize($file);
		$pos =$this->get_pos($this->thumb_w,$thumb_h,$img_info[0],$img_info[1]);
		$func="";
		switch($img_info[2]){
			case 1:
				$func="imagecreatefromgif";break;
			case 2:
				$func="imagecreatefromjpeg";break;
			case 3:
				$func="imagecreatefrompng";break;
		}
		//图片资源
		$img_res = $func($file);
		//画布资源
		$thumb_res = imagecreatetruecolor($pos[0],$pos[1]);
		imagecopyresized ($thumb_res ,$img_res,
		0,0,
		0,0
		 , $pos[0],$pos[1],$pos[2],$pos[3]);
		$func = str_replace("/", "",$img_info['mime']);
		$d = pathinfo($file);
		if(is_null($thumb_file)){
			$thumb_file = $d['dirname'].'/'.$d['filename']."_thumb.".$d['extension'];
		}else if(!strstr('/',$thumb_file)){
			$thumb_file = $d['dirname'].'/'.$thumb_file;
		}
		return $func($thumb_res,$thumb_file);
	}
	//获得缩略图画布的宽高与图片的宽高
	private function get_pos($t_w,$t_h,$img_w,$img_h){
		switch ($this->thumb_type) {
			case 2:
				$t_h = $t_w/$img_w*$img_h;
				break;
			default:
				if($img_w/$t_w>$img_h/$t_h){
				  	$img_w = $img_h/$t_h*$t_w;
				}else{
					$img_h = $img_w/$t_w*$t_h;
				}
		}
		return array($t_w,$t_h,$img_w,$img_h);
	}
	//验证文件和gd
	private function check_file($file){
		return is_file($file) and is_readable($file) && extension_loaded("gd");
	}
	//水印处理
	public function water($img){
		
	}
}













