<?php
/**
 * 无限分类操作类
 */
Class Category{
    //无限分类一维数组
	Static Public function unlimitedForLevel($cate,$pid=0,$level=0,$html="<s>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</s>")
	{
		$arr=array();
		foreach ($cate as $v)
		{

			if($v['pid']==$pid)
			{
				$v['level']=$level;
				$v['html']=str_repeat($html, $level);
				$arr[]=$v;
				$arr=array_merge($arr,self::unlimitedForLevel($cate,$v['cid'],$level+1,$html));
			}
		}
		return $arr;
	}
    //无线分类多维数组、
	Static Public function unlimitedForLayer($cate,$pid=0,$level=0)
	{
		$arr=array();
		foreach ($cate as $v) {
			if($v['pid']==$pid)
			{	
				$v['level']=$level;
				$v['child']=self::unlimitedForLayer($cate,$v['cid'],$level+1);
				$arr[]=$v;
			}
		}
		return $arr;
	}
    //传递子分类id返回所有父级分类
	Static Public function getParents($cate,$id){
		$arr=array();
		foreach ($cate as $v) {
			if($v['cid']==$id){
				$arr[]=$v;
				$arr=array_merge(self::getParents($cate,$v['pid']),$arr);
			}
		}
		return $arr;
	}
    //传递父级分类id返回所有子分类
	Static Public function getChildsId($cate,$pid)
	{
		$arr=array();
		foreach ($cate as $v) {
			if($v['pid']==$pid)
			{
				$arr[]=$v['cid'];
				$arr=array_merge($arr,self::getChildsId($cate,$v['cid']));
			}
		}
		return $arr;
	}
}
?>