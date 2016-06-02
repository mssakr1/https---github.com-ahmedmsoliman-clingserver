<?php
// for profile user
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



if (!($stmt = $mysqli->prepare("select b.id,b.img,b.name,b.desc,b.url,b.allowAnyOne from Brands b, mangers_user_branads m where m.id_user=? and m.id_brand = b.id"))) {
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



$out_br_id= NULL;
$out_br_img = NULL;

$out_br_name = NULL;
$out_br_desc = NULL;
$out_br_url = NULL;
$out_br_allow = NULL;

if (!$stmt->bind_result($out_br_id,$out_br_img, $out_br_name, $out_br_desc, $out_br_url, $out_br_allow)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('br_id' => $out_br_id, 'br_name' => $out_br_name,'br_img' => $out_br_img, 'br_desc' => $out_br_desc, 'br_url' => $out_br_url, 'br_allow' => $out_br_allow);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json,'message'=>'');
echo json_encode($arr);

$stmt->close();
?>