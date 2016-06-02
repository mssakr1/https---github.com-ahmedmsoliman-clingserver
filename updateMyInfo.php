<?php
include  'dbc.php';
require_once 'imageSave.php';

header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];

$br_id=$_POST['br_id'];

$b_name=$_POST['b_name'];
$b_desc=$_POST['b_desc'];
$b_url=$_POST['b_url'];
$b_allow=$_POST['b_allow'];
//$b_img=$_POST['b_img'];



if (!isset ($u_id)||!isset ($accceesToken)||!isset ($br_id)||!isset ($b_name)||!isset ($b_desc)||!isset ($b_url)||!isset ($b_allow)||
    empty($u_id)||empty($accceesToken) ||empty($br_id)  ||empty($b_name)||empty($b_desc)||empty($b_url)||empty($b_allow) ) {

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
             $arr = array ('status'=>-1,'message'=>'error in DB connection-2 ');
            echo json_encode($arr);
            return ;
        }

$canCreatGroup=$auth->canCreatGroupForBrand($u_id, $br_id, $mysqli);

 if($canCreatGroup == -2){
             $arr = array ('status'=>-2,'message'=>'you can not create group for others ');
            echo json_encode($arr);
            return ;
        }else if($canCreatGroup == -1){
             $arr = array ('status'=>-1,'message'=>'error in DB connection-3 ');
            echo json_encode($arr);
            return ;
        }

        
        
  $imgObj=new imageSave();
$b_img=$imgObj->SaveImage($_FILES);
if ($b_img==null && (isset ($_FILES['file']['name']) && !empty($_FILES['file']['name']) && strlen($_FILES['file']['name'])>=3)) {
    $arr = array ('status'=>'error','data'=>'image Error');
    echo json_encode($arr);
    return ;
}      
        
        
if (!($stmt = $mysqli->prepare("update Brands set `name`=? , `desc`=? , url=? , allowAnyOne=? , img=? where id=?"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection-6'.$mysqli->error);
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('sssisi', $b_name,$b_desc,$b_url,$b_allow,$b_img,$br_id)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection-4');
    echo json_encode($arr);
    return;
}


if (!$stmt->execute() /*|| $stmt->affected_rows<=0*/) {
    $arr = array ('status'=>-1,'message'=>'error in DB connection-5');
    echo json_encode($arr);
    return;
}

$stmt->close();

$arr = array ('status'=>1,'message'=>'sucess');
echo json_encode($arr);





?>