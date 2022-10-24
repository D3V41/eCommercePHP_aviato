<?php
include_once '../services/cartServices.php';
include_once '../services/productServices.php';
include_once '../services/userServices.php';
include_once '../httpresponce/encodedResponce.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['userId'])) {
        $id = $_GET['userId'];

        $result1 = getUserById($id);
        $carts = getCartByUserId($id);
        if(empty($result1)){
            showResponce(404,"User not exist!");
        }
        else if(empty($carts)){
            showResponce(404,"No Products in cart found.");
        }else{
            showResponce(200,$carts);
        }
    }
    else if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $carts = getCartById($id);
        if(empty($carts)){
            showResponce(404,"No Products in cart found.");
        }else{
            showResponce(200,$carts);
        }
    } 
    else {
            showResponce(404,"Please Provide ID.");
    }
}


if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->productId) &&
        !empty($data->userId) &&
        !empty($data->quantity)
    ){
        $result1 = getUserById($data->userId);
        $result2 = getProductById($data->productId);
        $result3 = existCart($data->productId,$data->userId);
        
        if(empty($result1)){
            showResponce(404,"User not exist!");
        }
        else if(empty($result2)){
            showResponce(404,"Product not exist!");
        }
        else if(!$result3){
            $result4 = addCart($data->productId,$data->userId,$data->quantity);
            if($result4){
                showResponce(200,"Product added Cart!");
            }else {
                showResponce(404,"Not able to add!");
            }
        }else{
            showResponce(404,"Product already exist in cart!");
        }

    }else{
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="PUT"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->productId) &&
        !empty($data->userId) &&
        !empty($data->quantity) &&
        !empty($data->id)
    ){
        $result1 = getCartById($data->id);
        if(!empty($result1)){
            $result2 = updateCart($data->id,$data->productId,$data->userId,$data->quantity);
            if($result2){
                showResponce(200,"Cart updated!");
            }else {
                showResponce(404,"Not able to update!");
            }
        }else{
            showResponce(404,"Cart not exist!");
        }
        
    }else {
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $cart = getCartById($id);
        if(empty($cart)){
            showResponce(404,"No products in cart found.");
        }else{
            $result = deleteCart($id);
            if($result){
                showResponce(200,"Cart deleted!");
            } else{
                showResponce(404,"Unable to delete");
            }
        }
    } 
    else {
        showResponce(404,"No product in cart found.");
    }
}

?>