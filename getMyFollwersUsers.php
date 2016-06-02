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



if (!($stmt = $mysqli->prepare("select id,fName,lName,img,email,mobile,status from User u,status_user_brand s where u.id=s.id_user and (s.status=0 or s.status=1) and id_brand =?;"))) {
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



$out_f_id= NULL;
$out_f_fname = NULL;
$out_f_lname = NULL;
$out_f_img = NULL;
$out_f_email = NULL;
$out_f_mobile = NULL;
$out_f_status = NULL;

if (!$stmt->bind_result($out_f_id, $out_f_fname, $out_f_lname,$out_f_img,$out_f_email,$out_f_mobile,$out_f_status)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('f_id' => $out_f_id, 'f_fname' => $out_f_fname, 'f_lname' => $out_f_lname,
        'f_img'=>$out_f_img,'f_email'=>$out_f_email,'f_mobile'=>$out_f_mobile,'f_status'=>$out_f_status);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json, 'message'=>'');
echo json_encode($arr);

$stmt->close();
?>