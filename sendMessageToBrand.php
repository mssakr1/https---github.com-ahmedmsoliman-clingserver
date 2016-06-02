<?php
include  'dbc.php';
header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];

$b_id=$_POST['b_id'];

$sender=$_POST['sender'];
$m_type=$_POST['m_type'];
$m_data=$_POST['m_data'];



if (!isset ($u_id)||!isset ($accceesToken)||!isset ($sender)||!isset ($m_type)||!isset ($m_data)||!isset ($b_id)||
    empty($u_id)||empty($accceesToken) ||empty($sender)  ||empty($m_type) ||empty($m_data)||empty($b_id)) {

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




if (!($stmt = $mysqli->prepare("INSERT INTO `AList`.`messages_user_brands`(`sender`,`date`,`message_type`,`message_data`,`id_user`,`id_brand`)VALUES(?,now(),?,?,?,?);;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('issii', $sender,$m_type,$m_data,$u_id,$b_id)) {
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