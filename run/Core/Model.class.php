<?php
/**
 * 数据库操作类
 */
class Model{
	private $link;
	public $table;
	public $opt=array(
		'field'=>'*',
		'where'=>'',
		'group'=>'',
		'having'=>'',
		'order'=>'',
		'limit'=>''
		);
	public function __construct($table){
		$this->connect();
		$this->table=$table;
	}
	//数据库链接
	private function connect(){
		$this->link=new mysqli(C('DB_HOST'),C('DB_USER'),C('DB_PASSWD'),C('DB_NAME'));
		if($this->link->connect_error){
			die($this->link->connect_error);
		}
		$this->link->query('set names utf8');
	}
	//查询语句，返回数组
	public function query($sql){
		$result=$this->link->query($sql);
		if(!$result) return null;
		$rows=array();
		while($row=$result->fetch_assoc()){
			$rows[]=$row;
		}
		return $rows;
	}
	//增、删、改 执行语句
	public function exec($sql){
		$result=$this->link->query($sql);
		if(!$result) return false;
		//返回删除、更新影响的条数，或返回插入的新记录的ID;
		//这一句判断affected可能为0,所以要以insert_id来判断.只要$result不为false就表明执行成功。
		return $this->link->insert_id?$this->link->insert_id:$this->link->affected_rows;
	}
	/**
	 * 配置sql语句
	 */
	//field
	public function field($arg){
		$this->opt['field']=' '.$arg.' ';
		return $this;
	}
	//where
	public function where($arg){
		$_where=' WHERE ';
		if(is_string($arg)){
			$this->opt['where']=$_where.$arg.' ';
		}elseif(is_array($arg)){
			foreach ($arg as $k => $v) {
				$_where.=" $k='$v' and";
			}
			$this->opt['where']=substr($_where,0,-3);
		}
		return $this;
	}
	//group by
	public function group($arg){
		$this->opt['group']=' ';
		return $this;
	}
	//having
	public function having($arg){
		$this->opt['having']=' HAVING '.$arg;
		return $this;
	}
	//order
	public function order($arg){
		$this->opt['order']=' ORDER BY '.$arg;
		return $this;
	}
	//limit
	public function limit($arg){
		$this->opt['limit']=' LIMIT '.$arg;
		return $this;
	}
	//组合查询语句
	public function select(){
		$sql='SELECT '.$this->opt['field'].' FROM '.$this->table.$this->opt['where'].
		$this->opt['group'].$this->opt['having'].$this->opt['order'].$this->opt['limit'];
		return $this->query($sql);
	}
	//find查找单条记录
	public function find(){
		$this->limit(1);
		$result=$this->select();
		if(!empty($result))
			//将二位数组返回为一维数组
			return current($result);
	}
	//添加add
	public function add($data=null){
		$data=isset($data)?$data:$_POST;
		if(empty($data)) return;
		//格式化数据
		foreach ($data as $k=>$v) {
			$data[$k]="'".addslashes($v)."'";
		}
		$sql='INSERT INTO '.$this->table.'('.implode(',',array_keys($data)).') values ('.implode(',',array_values($data)).')';
		return $this->exec($sql);
	}
	//更新save
	public function save($data=null){
		if(!$this->opt['where']) return;
		$data=isset($data)?$data:$_POST;
		$sql="UPDATE ".$this->table." SET ";
		foreach ($data as $k => $v) {
			$sql.="`$k`='".addslashes($v)."',";
		}
		$sql=substr($sql,0,-1).$this->opt['where'];
		$s=$this->exec($sql);
		return $s===false?false:true;
	}
	//删除del
	public function del(){
		if(!$this->opt['where']) return;
		$sql="DELETE FROM ".$this->table.$this->opt['where'];
		return $this->exec($sql);
	}
	//count
	public function count(){
		$this->field('count(*) as total');
		$result=$this->select();
		if(empty($result)) return null;
		$_result=current($result);
		return $_result['total'];
	}
}