<?php
class MemberController extends CommonController{
	private $db;
	public function __construct(){
		parent::__construct();
		session_id() || session_start();
		if(!isset($_SESSION['uid']) or !isset($_SESSION['uname']) ){
			header('Location:./');
		}
		$this->db=new Model('member');
	}
	public function index(){
		$me=$this->db->where(array('uid'=>$_SESSION['uid']))->find();
		//头像
		if($me['avatar']){
			$me['avatar']=C('UPLOAD_DIR').'avatar/big/'.$me['avatar'];
		}else{
			$me['avatar']=C('TPL_PUBLIC').'images/avatar.png';
		}
		//提问数
		$_ask=new Model('ask');
		$ask=$_ask->where(array('uid'=>$_SESSION['uid']))->select();
		$ask_num=count($ask);

		//回答数
		$_answer=new Model('answer');
		$answer=$_answer->where(array('uid'=>$_SESSION['uid']))->select();
		$answer_num=count($answer);
		//采纳数
		$ado_num=0;
		foreach ($answer as $v) {
			$ado_num+=$_ask->where(array('sid'=>$v['sid']))->count();
		}
		//采纳率ratio
		@$ratio=round($ado_num/$answer_num,2)*100;
		$me['ask_num']=$ask_num;
		$me['answer_num']=$answer_num;
		$me['ratio']=$ratio.'%';
		$this->assign('me',$me);
		$this->assign('ask',$ask);
		$this->assign('answer',$answer);
		$this->display('Member/index.php');
	}
	//删除提问
	public function del_ask(){
		$aid=isset($_GET['aid'])?(int)$_GET['aid']:'';
		if(!$aid)die;
		$_ask=new Model('ask');
		if($_ask->where(array('aid'=>$aid))->del()){
			die('1');
		}else{
			die('0');
		}
	}
	//更换头像
	public function avatar(){
		$me=$this->db->where(array('uid'=>$_SESSION['uid']))->find();
		//头像
		if($me['avatar']){
			$me['avatar']=C('UPLOAD_DIR').'avatar/big/'.$me['avatar'];
		}else{
			$me['avatar']=C('TPL_PUBLIC').'images/avatar.png';
		}
		$this->assign('me',$me);
		$this->display('Member/avatar.php');
	}
	/**
	* 图像上传
	*/
	public function upload(){
		$file=$_FILES['Filedata'];
		// print_r($file);
		$upload=C('UPLOAD_DIR');
		is_dir($upload) or mkdir($upload,0777);
		if($file['error']==0 and is_uploaded_file($file['tmp_name']) and $file['size']<pow(1024,2)){
			$_info=getimagesize($file['tmp_name']);
			if(!in_array($_info[2], array(1,2,3)))exit('error');//如果不是图片类型，则退出。
			// $extension=substr(strrchr($file['name'],'.'),1);
			$extension=substr(strrchr($_info['mime'],'/'),1);
			$file_name=time().mt_rand(0,1000).'.'.$extension;
			$to="$upload".$file_name;
			if(move_uploaded_file($file['tmp_name'],$to)){
				$func=str_replace('/', 'createfrom',$_info['mime']);
				$img=$func($to);
				$imgW=$_info[0];//图像宽高
				$imgH=$_info[1];
				if($imgW<300 && $imgH<300){
					if($imgW>=$imgH){
						$resW=300;
						$resH=$imgH/($imgW/300);
					}else{
						$resW=$imgW/($imgH/300);
						$resH=300;
					}
					$res=imagecreatetruecolor($resW, $resH);
					$color=imagecolorallocate($res, 255, 255, 255);
					imagefill($res, 0, 0, $color);
					imagecopyresized($res, $img, 0, 0, 0, 0, $resW, $resH, $imgW, $imgH);
					$func=str_replace('/', '',$_info['mime']);
					if($func=='imagejpeg'){
						imagejpeg($res,$to,100);//JPEG
					}else{
						$func($res,$to);//PNG,和GIF
					} 
				}
				echo $to;
			}
		}
	}
	//头像裁切
	public function crop(){
		$arr=array('big'=>180,'middle'=>100,'small'=>50);
		$x=isset($_POST['x'])?(int)$_POST['x']:'';
		$y=isset($_POST['y'])?(int)$_POST['y']:'';
		$w=isset($_POST['w'])?(int)$_POST['w']:'';
		$h=isset($_POST['h'])?(int)$_POST['h']:'';
		$sImg=isset($_POST['sImg'])?$_POST['sImg']:'';

		if(!$sImg)exit('error');
		$_info=getimagesize($sImg);
		if(!in_array($_info[2], array(1,2,3)))exit('error');//如果不是图片类型，则退出。
		// $extension=substr(strrchr($file['name'],'.'),1);
		$extension=substr(strrchr($_info['mime'],'/'),1);
		$file_name=time().mt_rand(0,1000).'.'.$extension;
		$func=str_replace('/', 'createfrom', $_info['mime']);
		$img=$func($sImg);

		foreach ($arr as $k=>$v) {
			$res=imagecreatetruecolor($v, $v);
			if(function_exists('imagecopyresampled'))
			{	//gd库2支持函数，图像更清晰。
				imagecopyresampled($res,$img,0,0,$x,$y,$v,$v,$w,$h);
			}else{
				imagecopyresized($res,$img,0,0,$x,$y,$v,$v,$w,$h);
			}
			$toDir=C('UPLOAD_DIR').'avatar/'.$k;
			is_dir($toDir) or mkdir($toDir,0777,true);
			$to=$toDir.'/'.$file_name;
			$func=str_replace('/', '', $_info['mime']);
			if($func='imagejpeg'){
				imagejpeg($res,$to,100);
			}else{
				$func($res,$to);
			}
		}
		$uid=$_SESSION['uid'];
		if($this->db->where(array('uid'=>$uid))->save(array('avatar'=>$file_name)))
		{
			$this->success('头像更改成功','?c=member');
		}else{
			$this->error('出错了...','?c=member');
		}		
	}
}