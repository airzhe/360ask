<?php
class AskController extends CommonController{
	//提问页面
	public function question(){
		$question=isset($_POST['q'])?htmlspecialchars(trim($_POST['q'])):'';
		$this->assign('question',$question);
		$this->display('Ask/question.php');
	}
}