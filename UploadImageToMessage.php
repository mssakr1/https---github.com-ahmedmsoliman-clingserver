<?php
include  'dbc.php';
require_once 'imageSave.php';

header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];






if (!isset ($u_id)||!isset ($accceesToken)||
    empty($u_id)||empty($accceesToken)) {

    $arr = array ('status'=>-1,'message'=>'data must be at least 3 char ');
    echo json_encode($arr);
    return ;
}





$auth=new AuthManager();
$result_id=$auth->validTokenForId($accceesToken, $u_id, $mysqli);

        if($result_id == -2){
             $arr = array ('status'=>-2,'message'=>'you must login');
            echo json_encode($arr);
            return ;
        }else if($result_id == -1){
             $arr = array ('status'=>-1,'message'=>'error in DB connection ');
            echo json_encode($arr);
            return ;
        }


$imgObj=new imageSave();
$pic_in=$imgObj->SaveImage($_FILES);
if ($pic_in==null && (isset ($_FILES['file']['name']) && !empty($_FILES['file']['name']) && strlen($_FILES['file']['name'])>=3)) {
    $arr = array ('status'=>-1,'data'=>'image Error');
    echo json_encode($arr);
    return ;
}

$arr = array ('status'=>1,'message'=>'sucess' ,'data'=>$pic_in);
echo json_encode($arr);





?>