<?php

include 'dbc.php';

header('Content-Type: application/json');


$u_id = $_POST['u_id'];
$accceesToken = $_POST['Atoken'];
$id_brand= $_POST['id_brand'];


if (!isset($u_id) || !isset($accceesToken) ||!isset($id_brand) ||
        empty($u_id) || empty($accceesToken) || empty($id_brand)) {

    $arr = array('status' => -1, 'message' => 'data must be at least 3 char ');
    echo json_encode($arr);
    return;
}

$auth = new AuthManager();
$result_id = $auth->validTokenForId($accceesToken, $u_id, $mysqli);

if ($result_id == -2) {
    $arr = array('status' => -2, 'message' => 'you must login');
    echo json_encode($arr);
    return;
} else if ($result_id == -1) {
    $arr = array('status' => -1, 'message' => 'error in DB connection ');
    echo json_encode($arr);
    return;
}



if (!($stmt = $mysqli->prepare("SELECT * FROM messages_user_brands where id_user=? and id_brand=? ;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_param('ii', $u_id,$id_brand)) {

$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
//  echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    return;
}







if (!$stmt->execute()) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}



$out_m_id= NULL;
$out_m_sender = NULL;
$out_m_date = NULL;
$out_m_type = NULL;
$out_m_data = NULL;
$out_id_user = NULL;
$out_id_brand = NULL;
$out_id_g = NULL;


if (!$stmt->bind_result($out_m_id, $out_m_sender, $out_m_date, $out_m_type, $out_m_data,$out_id_user,$out_id_brand,$out_id_g)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('m_id' => $out_m_id, 'm_sender' => $out_m_sender, 'm_date' => $out_m_date, 'm_type' => $out_m_type, 'm_data' => $out_m_data,'m_id_user'=>$out_id_user,'m_id_brand'=>$out_id_brand);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json,'message'=>'');
echo json_encode($arr);

$stmt->close();
?>