<?php

include 'dbc.php';

header('Content-Type: application/json');


$u_id = $_POST['u_id'];
$accceesToken = $_POST['Atoken'];

if (!isset($u_id) || !isset($accceesToken) ||
        empty($u_id) || empty($accceesToken)) {

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



if (!($stmt = $mysqli->prepare("SELECT * FROM notificationss where id_user=?;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_param('i', $u_id)) {

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



$out_n_id= NULL;
$out_n_id_user = NULL;
$out_n_date = NULL;
$out_n_type = NULL;
$out_n_data = NULL;
$out_n_seen = NULL;


if (!$stmt->bind_result($out_n_id, $out_n_id_user, $out_n_date, $out_n_type, $out_n_data,$out_n_seen)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('n_id' => $out_n_id, 'n_date' => $out_n_date, 'n_type' => $out_n_type, 'n_data' => $out_n_data, 'n_seen' => $out_n_seen);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json);
echo json_encode($arr);

$stmt->close();
?>