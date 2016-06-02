<?php
include_once './AuthManager.php';
include_once './Helper.php';

class conection{


function __construct(){

$uName='root';
$pass='root';
$mysqli = new mysqli("localhost", $uName, $pass, "AList",3306);

$this->mysqli=$mysqli;
if ($mysqli->connect_errno) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
echo json_encode($arr);
return;

}

}


}

$oo=new conection();
$mysqli=$oo->mysqli;

?>