<?php
include_once '../services/userServices.php';
include_once '../httpresponce/encodedResponce.php';
include_once '../config/manageCookie.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $user = getUserById($id);
        if(empty($user)){
            showResponce(404,"No users found.");
        }else{
            showResponce(200,$user);
        }
    } 
    else {
        $allusers = getAllUsers();
        if($allusers["count"]>0){
            showResponce(200,$allusers);
        } else{
            showResponce(404,"No users found.");
        }
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->name) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->shipping_address)
    ){
        $user = existUser($data->email);
        if(empty($user)){
            $result = registerUser($data->name,$data->email,$data->password,$data->shipping_address);
            if($result){
                showResponce(200,"User Registered!");
            }else {
                showResponce(404,"Not able to register!");
            }
        }else{
            showResponce(404,"User already exist!");
        }

    }else if(!empty($data->email) && !empty($data->password)){
        $user = loginUser($data->email,$data->password);
        if(empty($user)){
            showResponce(404,"Invalid Credentials!");
        }else {
            showResponce(200,"Successfully login!");
            generateCookie($data->email,$data->password);
            
        }
    }else if(!empty($data->email)){
        $isLoggedIn = getCookie($data->email);
        if($isLoggedIn){
            $user = getProfile($data->email);
            if(!empty($user)){
                showResponce(200,$user);
            }else {
                showResponce(404,"Wrong email!");
            }
            
        }else{
            showResponce(404,"User is not logged in");
        }
    }else{
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="PUT"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->name) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->shipping_address) &&
        !empty($data->id)
    ){
        $isLoggedIn = getCookie($data->email);
        if($isLoggedIn){
            $result = updateUserInfo($data->id,$data->name,$data->email,$data->password,$data->shipping_address);
            if($result){
                showResponce(200,"User updated!");
            }else {
                showResponce(404,"Not able to update!");
            }
        }else{
            showResponce(404,"User is not logged in");
        }
        
    }else {
        showResponce(404,"Invalid Inputes!");
    }
}


?>