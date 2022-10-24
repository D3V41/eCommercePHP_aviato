<?php
include_once '../services/productServices.php';
include_once '../httpresponce/encodedResponce.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = getProductById($id);
        if(empty($product)){
            showResponce(404,"No products found.");
        }else{
            showResponce(200,$product);
        }
    } 
    else {
        $products = getProducts();
        if($products["count"]>0){
            showResponce(200,$products);
        } else{
            showResponce(404,"No products found.");
        }
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->type) &&
        !empty($data->title) &&
        !empty($data->details) &&
        !empty($data->oldPrice) &&
        !empty($data->newPrice) &&
        !empty($data->src)
    ){
        $result1 = existProduct($data->type,$data->title);
        
        if($result1){
            $result2 = addProduct($data->type,$data->title,$data->details,$data->oldPrice,$data->newPrice,$data->src);
            if($result2){
                showResponce(200,"Product added!");
            }else {
                showResponce(404,"Not able to add!");
            }
        }else{
            showResponce(404,"Product already exist!");
        }

    }else{
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="PUT"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->type) &&
        !empty($data->title) &&
        !empty($data->details) &&
        !empty($data->oldPrice) &&
        !empty($data->newPrice) &&
        !empty($data->src) &&
        !empty($data->id)
    ){
        $result1 = getProductById($data->id);
        if(!empty($result1)){
            $result2 = updateProduct($data->id,$data->type,$data->title,$data->details,$data->oldPrice,$data->newPrice,$data->src);
            if($result2){
                showResponce(200,"Product updated!");
            }else {
                showResponce(404,"Not able to update!");
            }
        }else{
            showResponce(404,"Product not exist!");
        }
        
    }else {
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $product = getProductById($id);
        if(empty($product)){
            showResponce(404,"No products found.");
        }else{
            $result = deleteProduct($id);
            if($result){
                showResponce(200,"Product deleted!");
            } else{
                showResponce(404,"Unable to delete");
            }
        }
    } 
    else {
        showResponce(404,"No products found.");
    }
}
?>