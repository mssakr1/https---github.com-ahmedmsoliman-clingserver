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
class helper {

    //put your code here





    function ValidEmail($u_email, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("select id from User where email=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('s', $u_email)) {

            
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
                    $stmt->close();

            return $out_id;   
            
        }else{
                       $stmt->close();
 
        return -2;
        
        }
    }
    
    
   

    
    
    
     function insertNewUser($u_fName,$u_lName,$u_img,$u_email,$u_mobile,$u_fbToken,$mysqli) {
        
        if (!($stmt = $mysqli->prepare("insert into User(fName,lName,img,email,mobile,fbToken) values(?,?,?,?,?,?);"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('ssssss', $u_fName,$u_lName,$u_img,$u_email,$u_mobile,$u_fbToken)) {

            
            return -1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        
        return  $stmt->insert_id;
       
    }

    
    
     function isOldUser($FBaccessToken, $u_email, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT id FROM User u where email=? ;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('s', $u_email)) {

            
            return -1 ;
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
   
    
    
    function getUserBrandStatus($u_id,$b_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT status FROM status_user_brand u where id_user=?  and id_brand=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('ii', $u_id,$b_id)) {

            
            return -1 ;
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
                
            return 2;//not following
        
        }
    }
   
    
    
    function getBrandFollowingType($b_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT allowAnyOne FROM Brands u where id=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('i', $b_id)) {

            
            return -1 ;
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
                
            return -1;//
        
        }
    }
    
    function getUserOldmobile($u_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT mobile FROM User u where id=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('i', $u_id)) {

            
            return -1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        $out_mobile = NULL;
      
        if (!$stmt->bind_result($out_mobile)) {
           
            return -1;
            
        }
        if($row = $stmt->fetch()) {
            
            return $out_mobile;   
            
        }else{
                
            return -1;//
        
        }
    }
    
    
    
    function getUserAdminStatus($u_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT isAdmin FROM User u where id=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('i', $u_id)) {

            
            return -1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        $out_isAdmin = NULL;
      
        if (!$stmt->bind_result($out_isAdmin)) {
           
            return -1;
            
        }
        if($row = $stmt->fetch()) {
            
            return $out_isAdmin;   
            
        }else{
                
            return -1;//
        
        }
    }
    
    
    
    function getUserRegDate($u_id, $mysqli) {
        
        if (!($stmt = $mysqli->prepare("SELECT reg_date FROM User u where id=?;"))) {
           
            return -1;
        }




        if (!$stmt->bind_param('i', $u_id)) {

            
            return -1 ;
        }
        if (!$stmt->execute()) {
           
            return -1;
        }

        $out_isAdmin = NULL;
      
        if (!$stmt->bind_result($out_isAdmin)) {
           
            return -1;
            
        }
        if($row = $stmt->fetch()) {
            
            return $out_isAdmin;   
            
        }else{
                
            return -1;//
        
        }
    }
}
