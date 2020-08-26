<?php

include('db.php');

$obj = new query();
$condition_arr = array('name'=>'Loki','email'=>'loki@example.com');

//select query
//$result = $obj->getData('user','*',$condition_arr,'id','asc','');

//insert query
//$result = $obj->insertData('user',$condition_arr);

//delete query
//$result = $obj->deleteData('user',$condition_arr);

//update query
//$result = $obj->updateData('user',$condition_arr,'id',5);

?>