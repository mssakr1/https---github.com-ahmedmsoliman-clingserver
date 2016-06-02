<?php
include  'dbc.php';
require_once 'imageSave.php';

header('Content-Type: application/json');



$u_id=$_POST['u_id'];
$accceesToken=$_POST['Atoken'];

$br_id=$_POST['br_id'];

$g_id=$_POST['g_id'];
$Ou_id=$_POST['Ou_id'];
$opType=$_POST['opType'];// 2 insert 3 delete

//echo $opType.' '.$Ou_id.' '.$g_id;

if (!isset ($u_id)||!isset ($accceesToken)||!isset ($br_id)||!isset ($g_id)||!isset ($Ou_id)||!isset ($opType)||
    empty($u_id)||empty($accceesToken) ||empty($br_id)  ||empty($g_id)||empty($Ou_id)||empty($opType)) {

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

        
        

        if($opType==2){
        

                if (!($stmt = $mysqli->prepare("INSERT IGNORE INTO users_in_group VALUES (?,?) "))) {
                $arr = array ('status'=>-1,'message'=>'error in DB connection');
                    echo json_encode($arr);
                    return;
                }




                if (!$stmt->bind_param('ii', $g_id,$Ou_id)) {
                $arr = array ('status'=>-1,'message'=>'error in DB connection');
                    echo json_encode($arr);
                    return;
                }

        }else if($opType==3){
                        
                if (!($stmt = $mysqli->prepare("delete from users_in_group where id_group=? and id_user=? ;"))) {
                $arr = array ('status'=>-1,'message'=>'error in DB connection');
                    echo json_encode($arr);
                    return;
                }




                if (!$stmt->bind_param('ii', $g_id,$Ou_id)) {
                $arr = array ('status'=>-1,'message'=>'error in DB connection');
                    echo json_encode($arr);
                    return;
                }       
        }else{
                $arr = array ('status'=>-1,'message'=>'error ');
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