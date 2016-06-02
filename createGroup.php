<?php
include  'dbc.php';
header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];

$br_id=$_POST['br_id'];
$group_title=$_POST['g_title'];



if (!isset ($u_id)||!isset ($accceesToken)||!isset ($br_id)||!isset ($group_title)||
    empty($u_id)||empty($accceesToken) ||empty($br_id)  ||empty($group_title) ) {

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
             $arr = array ('status'=>-1,'message'=>'2error in DB connection ');
            echo json_encode($arr);
            return ;
        }

$canCreatGroup=$auth->canCreatGroupForBrand($u_id, $br_id, $mysqli);

 if($canCreatGroup == -2){
             $arr = array ('status'=>-2,'message'=>'you can not create group for others ');
            echo json_encode($arr);
            return ;
        }else if($canCreatGroup == -1){
             $arr = array ('status'=>-1,'message'=>'3error in DB connection ');
            echo json_encode($arr);
            return ;
        }

        
        
        
        
        
if (!($stmt = $mysqli->prepare("INSERT INTO `group` (`name`,`owner_brand_id`) values(?,?)"))) {
$arr = array ('status'=>-1,'message'=>'4error in DB connection');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('si', $group_title,$br_id)) {
$arr = array ('status'=>-1,'message'=>'5error in DB connection');
    echo json_encode($arr);
    return;
}


if (!$stmt->execute() /*|| $stmt->affected_rows<=0*/) {
    $arr = array ('status'=>-1,'message'=>'6error in DB connection');
    echo json_encode($arr);
    return;
}

$stmt->close();

$arr = array ('status'=>1,'message'=>'sucess');
echo json_encode($arr);





?>