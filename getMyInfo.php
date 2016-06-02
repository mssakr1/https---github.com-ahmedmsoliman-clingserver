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
    $arr = array('status' => -1, 'message' => 'error in DB connection ');
    echo json_encode($arr);
    return;
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



if (!($stmt = $mysqli->prepare("SELECT * from Brands where id=?;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_param('i', $br_id)) {

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



$out_b_id= NULL;
$out_b_name = NULL;
$out_b_desc = NULL;
$out_b_url = NULL;
$out_b_allow = NULL;
$out_b_img = NULL;



if (!$stmt->bind_result($out_b_id, $out_b_name, $out_b_desc,$out_b_url,$out_b_allow,$out_b_img)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


//$json = array();



if ($row = $stmt->fetch()) {

    $json = array('b_id' => $out_b_id, 'b_name' => $out_b_name, 'b_desc' => $out_b_desc,'b_url'=>$out_b_url,'b_allow'=>$out_b_allow,'b_img'=>$out_b_img);


//    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json,'message'=>'');
echo json_encode($arr);

$stmt->close();
?>