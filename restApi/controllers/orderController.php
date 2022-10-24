<?php
include_once '../services/orderServices.php';
include_once '../services/productServices.php';
include_once '../services/userServices.php';
include_once '../httpresponce/encodedResponce.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['userId'])) {
        $id = $_GET['userId'];
        $order = getOrderByUserId($id);
        if(empty($order)){
            showResponce(404,"No order found.");
        }else{
            showResponce(200,$order);
        }
    } 
    else {
        $orders = getOrders();
        if($orders["count"]>0){
            showResponce(200,$orders);
        } else{
            showResponce(404,"No order found.");
        }
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->product) &&
        !empty($data->userId) &&
        !empty($data->address)
    ){
        $result1 = getUserById($data->userId);
        
        if(empty($result1)){
            showResponce(404,"User not exist!");
        }
        else{
            $result2 = addOrder($data->product,$data->userId,$data->address);
            if($result2){
                showResponce(200,"Product added Cart!");
            }else {
                showResponce(404,"Not able to add!");
            }
        }

    }else{
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $order = getOrderById($id);
        if(empty($order)){
            showResponce(404,"No order found.");
        }else{
            $result = deleteOrder($id);
            if($result){
                showResponce(200,"order deleted!");
            } else{
                showResponce(404,"Unable to delete");
            }
        }
    } 
    else {
        showResponce(404,"No order found.");
    }
}

?>