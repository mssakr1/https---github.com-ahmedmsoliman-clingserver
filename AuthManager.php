<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthManager
 *
 * @author TOSHIBA
 */
class AuthManager {

    //put your code here





    function validTokenForId($accessToken, $u_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT id_user FROM user_auth u where id_user=? and accessToken=? and TIME_TO_SEC(TIMEDIFF(expires_date,now())) > 0;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('is', $u_id, $accessToken)) {

            
            return-1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        $out_id = NULL;
      
        if (!$stmt->bind_result($out_id)) {
           
            return -1;
            
        }
        if($row = $stmt->fetch()) {
            
            return $out_id;   
            
        }else{
                
        return -2;
        
        }
    }
    
    
    
    
    

    
    
    function canCreatGroupForBrand( $u_id, $b_id,$mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT * FROM mangers_user_branads where id_user=? and id_brand=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('ii', $u_id, $b_id)) {

            
            return-1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        $out_idU = NULL;
        $out_idB = NULL;
      
        if (!$stmt->bind_result($out_idU,$out_idB)) {
           
            return -1;
            
        }
        if($row = $stmt->fetch()) {
            
            return 1;   
            
        }else{
                
        return -2;
        
        }
    }
    
    
    function AddNewAccessTokenForUserId($u_id, $mysqli) {

        
        $accessToken = md5($u_id . 'S@krR' . rand() . 'M0Hamed');

//        $mysqli.
//        $mysqli->
        
        if (!($stmt = $mysqli->prepare("INSERT INTO user_auth(`id_user`,`accessToken`,`expires_date`) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 30 DAY)) ON DUPLICATE KEY UPDATE `accessToken`= ? , `expires_date`= DATE_ADD(NOW(), INTERVAL 30 DAY);"))) {
            
            return -1;
        }




        if (!$stmt->bind_param('iss', $u_id,$accessToken,$accessToken)) {

            return -1;
        }

        if (!$stmt->execute()) {

            return -1;
        }

        $stmt->close();

        return $accessToken;
    }
    
    
    
    function AddNewAccessTokenForUserIdWithPush($u_id,$pushToken,$deviceType, $mysqli) {

        
        $accessToken = md5($u_id . 'S@krR' . rand() . 'M0Hamed');

//        $mysqli.
//        $mysqli->
        
        if (!($stmt = $mysqli->prepare("INSERT INTO user_auth(`id_user`,`accessToken`,`expires_date`,`pushToken`,`deviceType`) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 30 DAY),?,?) ON DUPLICATE KEY UPDATE `accessToken`= ? , `expires_date`= DATE_ADD(NOW(), INTERVAL 30 DAY) , `pushToken`= ? , `deviceType` = ?;"))) {
            
            return -1;
        }




        if (!$stmt->bind_param('ississi', $u_id,$accessToken,$pushToken,$deviceType,$accessToken,$pushToken,$deviceType)) {

            return -1;
        }

        if (!$stmt->execute()) {

            return -1;
        }

        $stmt->close();

        return $accessToken;
    }

}
