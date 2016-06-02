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



if (!($stmt = $mysqli->prepare("SELECT distinct b.id,b.img,b.name,b.desc,b.url,b.allowAnyOne,ifnull(x.status,2) 'status',ifnull(n_count,0) 'noti_c' FROM Brands b  left join   
( 
select s.id_brand ,n_count,status 
from 
status_user_brand s
left join 
(
SELECT notifi_data 'id_brand',count(notifi_data) 'n_count' , id_user FROM notificationss where id_user=? and ( notifi_type=1 or notifi_type=2) and seen=0 group by notifi_data 
) t
 on t.id_brand=s.id_brand 

) as x 
on b.id=x.id_brand  where  (status = 0 or status = 1 )"))) {
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
$out_br_status = NULL;
$out_br_notiNum = NULL;

if (!$stmt->bind_result($out_br_id,$out_br_img, $out_br_name, $out_br_desc, $out_br_url, $out_br_allow,$out_br_status,$out_br_notiNum)) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
    //echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}


$json = array();



while ($row = $stmt->fetch()) {

    $Tempjson = array('br_id' => $out_br_id, 'br_name' => $out_br_name,'br_img' => $out_br_img, 'br_desc' => $out_br_desc, 'br_url' => $out_br_url, 'br_allow' => $out_br_allow,'br_status'=>$out_br_status,'br_notiNum'=>$out_br_notiNum);


    $json[] = $Tempjson;
}
$arr = array('status' =>1, 'data' => $json,'message'=>'');
echo json_encode($arr);

$stmt->close();
?>