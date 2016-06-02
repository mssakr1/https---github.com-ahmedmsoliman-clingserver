<?php
include  'dbc.php';
require_once 'imageSave.php';

header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];

$br_id=$_POST['br_id'];

$g_id=$_POST['g_id'];
$g_name=$_POST['g_name'];




if (!isset ($u_id)||!isset ($accceesToken)||!isset ($br_id)||!isset ($g_id)||!isset ($g_name)||
    empty($u_id)||empty($accceesToken) ||empty($br_id)  ||empty($g_id)||empty($g_name)) {

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

$canCreatGroup=$auth->canCreatGroupForBrand($u_id, $br_id, $mysqli);

 if($canCreatGroup == -2){
             $arr = array ('status'=>-2,'message'=>'you can not create group for others ');
            echo json_encode($arr);
            return ;
        }else if($canCreatGroup == -1){
             $arr = array ('status'=>-1,'message'=>'error in DB connection ');
            echo json_encode($arr);
            return ;
        }

        
        
     
        
        
if (!($stmt = $mysqli->prepare("update group set name=? where id=? and owner_brand_id=?"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('sii', $g_name,$g_id,$br_id)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}


if (!$stmt->execute() /*|| $stmt->affected_rows<=0*/) {
    $arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}

$stmt->close();

$arr = array ('status'=>1,'message'=>'sucess');
echo json_encode($arr);





?>