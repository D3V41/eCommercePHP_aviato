<?php 
include_once '../services/reviewServices.php';
include_once '../services/productServices.php';
include_once '../services/userServices.php';
include_once '../httpresponce/encodedResponce.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $reviews = getReviewsByProductId($id);
        if(empty($reviews)){
            showResponce(404,"No reviews found.");
        }else{
            showResponce(200,$reviews);
        }
    } 
    else {
        $reviews = getreviews();
        if($reviews["count"]>0){
            showResponce(200,$reviews);
        } else{
            showResponce(404,"No reviews found.");
        }
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->productId) &&
        !empty($data->userId) &&
        !empty($data->date) &&
        !empty($data->username) &&
        !empty($data->review) &&
        !empty($data->src)
    ){
        $result1 = getUserById($data->userId);
        $result2 = getProductById($data->productId);
        $result3 = existReview($data->productId,$data->userId);
        if(empty($result1)){
            showResponce(404,"User not exist!");
        }
        else if(empty($result2)){
            showResponce(404,"Product not exist!");
        }
        else if($result3>=1){
            showResponce(404,"Review already exist!");
        }
        else{
            $result4 = addReview($data->productId,$data->userId,$data->date,$data->username,$data->review,$data->src);
            if($result4){
                showResponce(200,"Review added!");
            }else {
                showResponce(404,"Not able to add!");
            }
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
        !empty($data->date) &&
        !empty($data->username) &&
        !empty($data->review) &&
        !empty($data->src) &&
        !empty($data->id)
    ){
        $result1 = getReviewById($data->id);
        if(!empty($result1)){
            $result2 = updateReview($data->id,$data->productId,$data->userId,$data->date,$data->username,$data->review,$data->src);
            if($result2){
                showResponce(200,"Review updated!");
            }else {
                showResponce(404,"Not able to update!");
            }
        }else{
            showResponce(404,"Review not exist!");
        }
        
    }else {
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $review = getReviewById($id);
        if(empty($review)){
            showResponce(404,"No reviews found.");
        }else{
            $result = deleteReview($id);
            if($result){
                showResponce(200,"review deleted!");
            } else{
                showResponce(404,"Unable to delete");
            }
        }
    } 
    else {
        showResponce(404,"No reviews found.");
    }
}

?>