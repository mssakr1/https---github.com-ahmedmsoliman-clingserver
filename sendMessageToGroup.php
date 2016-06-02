<?php
include  'dbc.php';
header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];



$br_id=$_POST['br_id'];
$group_id=$_POST['g_id'];


$sender=$br_id;
$m_type=$_POST['m_type'];
$m_data=$_POST['m_data'];



if (!isset ($u_id)||!isset ($accceesToken)||!isset ($sender)||!isset ($m_type)||!isset ($m_data)||!isset ($br_id)||
    empty($u_id)||empty($accceesToken) ||empty($sender)  ||empty($m_type) ||empty($m_data)||empty($br_id)) {

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
             $arr = array ('status'=>-1,'message'=>'error in DB connection 22');
            echo json_encode($arr);
            return ;
        }




if (!($stmt = $mysqli->prepare("INSERT INTO `AList`.`messages_user_brands`(`sender`,`date`,`message_type`,`message_data`,`id_user`,`id_brand`,`g_id`) (select 2,now(),?,?,id_user,?,? from users_in_group,User where id_user=id and id_group=?);;"))) {

    $arr = array ('status'=>-1,'message'=>'error in DB connection33');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('isiii',$m_type,$m_data,$br_id,$group_id,$group_id)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection44');
    echo json_encode($arr);
    return;
}


if (!$stmt->execute() /*|| $stmt->affected_rows<=0*/) {
    $arr = array ('status'=>-1,'message'=>'error in DB connection55');
    echo json_encode($arr);
    return;
}

$stmt->close();

$arr = array ('status'=>1,'message'=>'sucess');
echo json_encode($arr);





?>