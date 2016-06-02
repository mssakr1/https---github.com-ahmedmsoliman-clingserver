<?php
include  'dbc.php';
header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];
$id_brand=$_POST['id_brand'];





if (!isset ($u_id)||!isset ($accceesToken)||!isset ($id_brand)||
    empty($u_id)||empty($accceesToken) ||empty($id_brand)) {

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



       
        
$hObj=new helper();

$statusUserBrand=$hObj->getUserBrandStatus($u_id, $id_brand, $mysqli);
        
$statusBrandAllowAny=$hObj->getBrandFollowingType($id_brand, $mysqli);


if($statusBrandAllowAny == -1 || $statusUserBrand == -1){
             $arr = array ('status'=>-1,'message'=>'error in DB connection ');
            echo json_encode($arr);
            return ;
}
        
switch ($statusUserBrand){
    case 0:
        
        $statusUserBrand=2;
        
        break;
    case 1:
        
        
        $statusUserBrand=1;
        break;
    case 2:
        
        
        if($statusBrandAllowAny==1){
            $statusUserBrand=0;
        }else{
            $statusUserBrand=1;
        }
        
        break;
    
}

        
        
        
        
        
        
        

if (!($stmt = $mysqli->prepare("INSERT INTO status_user_brand VALUES (?,?,?) ON DUPLICATE KEY UPDATE `status`= ? ;"))) {
$arr = array ('status'=>-1,'message'=>'error in DB connection');
    echo json_encode($arr);
    return;
}




if (!$stmt->bind_param('iiii', $u_id, $id_brand,$statusUserBrand,$statusUserBrand)) {
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

$arr = array ('status'=>1,'message'=>'sucess','data'=>$statusUserBrand);
echo json_encode($arr);





?>