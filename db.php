<?php

class database {
	//only this class can access
	private $host;
	private $dbusername;
	private $dbpassword;
	private $dbname;
	
	// only inherited classes can be access
	protected function connect() {
		$this->host='localhost';
		$this->dbusername='root';
		$this->dbpassword='';
		$this->dbname='oops';
		
		$con = new mysqli($this->host, $this->dbusername, $this->dbpassword, $this->dbname);
		return $con;
	}
	
	//for accessing protected function in mysqli_real_escape_string function
	public function get_safe_str($str) {
		if($str!='') {
			return mysqli_real_escape_string($this->connect(),$str);
		}
	}
}

class query extends database {
	public function getData($table,$field='*',$condition_arr='',$order_by_field='',$order_by_type='desc',$limit='') {
		$sql="select $field from $table ";
		if($condition_arr!='') {
			$sql.=' where ';
			$c=count($condition_arr);
			$i=1;
			foreach($condition_arr as $key=>$val) {
				if($i==$c) {
					$sql.="$key='$val'";
				} else {
					$sql.="$key='$val' and ";
				}
				$i++;
			}
		}
		if($order_by_field!='') {
			$sql.=" order by $order_by_field $order_by_type ";
		}
		if($limit!='') {
			$sql.=" limit $limit";
		}
		//die($sql);
		$result = $this->connect()->query($sql);
		if($result->num_rows>0) {
			$arr = array();
			while($row=$result->fetch_assoc()) {
				//[] for displaying complete array
				$arr[]=$row;
			}
			return $arr;
		}else {
			return 0;
		}
	}
	
	public function insertData($table,$condition_arr='') {
		if($condition_arr!='') {
			foreach($condition_arr as $key=>$val) {
				$field_arr[]=$key;
				$value_arr[]=$val;
			}
			$field=implode(",",$field_arr);
			$value=implode("','",$value_arr);
			$value="'".$value."'";
			$sql="insert into $table($field) values($value) ";
			$result = $this->connect()->query($sql);
		}
	}
	
	public function deleteData($table,$condition_arr='') {
		if($condition_arr!='') {
			$sql="delete from $table where ";
			$c=count($condition_arr);
			$i=1;
			foreach($condition_arr as $key=>$val) {
				if($i==$c) {
					$sql.="$key='$val'";
				} else {
					$sql.="$key='$val' and ";
				}
				$i++;
			}
			//echo $sql;
			$result = $this->connect()->query($sql);
		}
	}
	
	public function updateData($table,$condition_arr='',$where_field,$where_value) {
		if($condition_arr!='') {
			$sql="update $table set ";
			$c=count($condition_arr);
			$i=1;
			foreach($condition_arr as $key=>$val) {
				if($i==$c) {
					$sql.="$key='$val'";
				} else {
					$sql.="$key='$val', ";
				}
				$i++;
			}
			$sql.=" where $where_field='$where_value' ";
			//echo $sql;
			$result = $this->connect()->query($sql);
		}
	}
}


/*
select $field from $table where id='1' and name='john' and name like '%or%' order by name limit 1;

select $field from $table where $condition and like $like order by $order_by_field $order_by_type limit $limit;

$field-> * or name, email
$table-> user


*/

?>