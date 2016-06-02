<?php
include  'dbc.php';
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




if (!($stmt = $mysqli->prepare("delete from user_auth where id_user=? and accessToken=?;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('is', $u_id,$accceesToken)) {
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