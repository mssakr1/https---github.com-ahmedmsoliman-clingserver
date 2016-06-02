<?php

include 'dbc.php';

header('Content-Type: application/json');


$u_id = $_POST['u_id'];
$accceesToken = $_POST['Atoken'];
$br_id=$_POST['br_id'];


if (!isset($u_id) || !isset($accceesToken) ||!isset($br_id) ||
        empty($u_id) || empty($accceesToken)|| empty($br_id)) {

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
    $arr = array('status' => -1, 'message' => 'error in DB connection 55');
    echo json_encode($arr);
    return;
}



$canCreatGroup=$auth->canCreatGroupForBrand($u_id, $br_id, $mysqli);

 if($canCreatGroup == -2){
             $arr = array ('status'=>-2,'message'=>'you can not create group for others ');
            echo json_encode($arr);
            return ;
        }else if($canCreatGroup == -1){
             $arr = array ('status'=>-1,'message'=>'eerror in DB connection ');
            echo json_encode($arr);
            return ;
        }



if (!($stmt = $mysqli->prepare("SELECT * from `group` where owner_brand_id=?;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection4');





echo json_encode($arr);

    return;
}

if (!$stmt->bind_param('i', $br_id)) {

$arr = array ('status'=>-1,'message'=>'2error in DB connection');
    echo json_encode($arr);
    return;
}







if (!$stmt->execute()) {
$arr = array ('status'=>-1,'message'=>'3error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}



$out_g_id= NULL;
$out_g_name = NULL;
$out_g_owner = NULL;


if (!$stmt->bind_result($out_g_id, $out_g_name, $out_g_owner)) {
$arr = array ('status'=>-1,'message'=>'4error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('g_id' => $out_g_id, 'g_name' => $out_g_name, 'g_owner' => $out_g_owner);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json,'message'=>'');
echo json_encode($arr);

$stmt->close();
?>