<?php 
require_once 'Facebook/autoload.php';

include 'dbc.php';

header('Content-Type: application/json');




$email=$_POST['email'];
$FBaccessToken=$_POST['FbToken'];

$pushToken=$_POST['pushToken'];
$deviceType=$_POST['deviceType'];


if (!isset ($email)|| empty($email) || !isset($FBaccessToken)|| empty($FBaccessToken)  || !isset($pushToken)|| empty($pushToken)  || !isset($deviceType)|| empty($deviceType) ) {

    $arr = array ('status'=>-1,'message'=>'data must be at least 3 char ');
    echo json_encode($arr);
    return ;
}






$fb = new Facebook\Facebook([
  'app_id' => '889024967824244',
  'app_secret' => 'a7cf4fada906d69b817061cf475fc1d4',
  'default_graph_version' => 'v2.5' // optional
]);

$tokenn=$FBaccessToken;//'CAAMokEFnU3QBAE5A8LskzuLzcCQ3Qylzo7VgXfS2ZCkIvtqMWUhOZCN34sD7OLihHo11pStBjIos9U3KO2H8zYLWtwhTQzVIVgPwPi4JK8s4d5GPFH1jFsFgawxcTXV5ILuZA3WAuDV4KSv1hmPbhZCHIVQvniSXG1qxEupOyIbuplapXt9POsiR8yCdSGhKZBeLZBcTwo8n3csRS5ZCdWbzDJftoZCTbMMZD';

try {
  // Get the Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me?fields=id,name,first_name,last_name,email,picture', $tokenn);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
//  echo 'Graph returned an error: ' . $e->getMessage();
  
  
   $arr = array ('status'=>-1,'message'=>'Facebook Error');
    echo json_encode($arr);
    return ;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
//  echo 'Facebook SDK returned an error: ' . $e->getMessage();
     $arr = array ('status'=>-1,'message'=>'Facebook Error');
    echo json_encode($arr);
    return ;
}

$me = $response->getGraphUser();
//echo $me;



if($email != $me->getEmail()){
    $arr = array ('status'=>-1,'message'=>'Wrong email address');
    echo json_encode($arr);
    return ;
}

$obj=new helper();



$reultInsertId=$obj->isOldUser($tokenn, $me->getEmail(), $mysqli);



if($reultInsertId == -1){
         $arr = array ('status'=>-1,'message'=>'Error');
    echo json_encode($arr);
    return ;
}else if($reultInsertId == -2){
         ///user not found insert new one
    
        $reultInsertId=$obj->insertNewUser($me->getFirstName(), $me->getLastName(), $me->getPicture()->getUrl(), $me->getEmail(), '', $tokenn,$mysqli);




        if($reultInsertId == -1){
             $arr = array ('status'=>-1,'message'=>'Error');
            echo json_encode($arr);
            return ;
        }
    
    
}



$userMobile=$obj->getUserOldmobile($reultInsertId, $mysqli);

if($userMobile ==-1){
       $arr = array ('status'=>-1,'message'=>'Error');
       echo json_encode($arr);
       return ;
}



///update access token

$auth=new AuthManager();

$accessTokenSession=$auth->AddNewAccessTokenForUserIdWithPush($reultInsertId,$pushToken,$deviceType, $mysqli);


$userisAdmin=$obj->getUserAdminStatus($reultInsertId, $mysqli);


if($accessTokenSession != -1 && $userisAdmin!=-1){
    
    
    
    
    $uDaat=array('_id'=>$reultInsertId,'fname'=>$me->getFirstName(),'lname'=>$me->getLastName(),'email'=>$me->getEmail(),'img'=>$me->getPicture()->getUrl(),'mobile'=>$userMobile,'acessToken'=>$accessTokenSession,'isAdmin'=>$userisAdmin);
    
    
    $arr = array ('status'=>1,'message'=>'','data'=>$uDaat);
    echo json_encode($arr);
    return ;
    
    
    
    
    
}else{
       $arr = array ('status'=>-1,'message'=>'Error');
    echo json_encode($arr);
    return ;
}



      




?>