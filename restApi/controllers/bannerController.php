<?php
include_once '../services/bannerServices.php';
include_once '../httpresponce/encodedResponce.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD']=="GET"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $banner = getBannerById($id);
        if(empty($banner)){
            showResponce(404,"No banners found.");
        }else{
            showResponce(200,$banner);
        }
    } 
    else {
        $banners = getBanners();
        if($banners["count"]>0){
            showResponce(200,$banners);
        } else{
            showResponce(404,"No products found.");
        }
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->name) &&
        !empty($data->title) &&
        !empty($data->subtitle) &&
        !empty($data->src)
    ){
        $result1 = existBanner($data->name,$data->title);
        if($result1){
            $result2 = addBanner($data->name,$data->title,$data->subtitle,$data->src);
            if($result2){
                showResponce(200,"Banner added!");
            }else {
                showResponce(404,"Not able to add!");
            }
        }else{
            showResponce(404,"Banner already exist!");
        }

    }else{
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="PUT"){
    $data = json_decode( file_get_contents( 'php://input' ) );
    if(
        !empty($data->name) &&
        !empty($data->title) &&
        !empty($data->subtitle) &&
        !empty($data->src) &&
        !empty($data->id)
    ){
        $result1 = getBannerById($data->id);
        if(!empty($result1)){
            $result2 = updateBanner($data->id,$data->name,$data->title,$data->subtitle,$data->src);
            if($result2){
                showResponce(200,"Banner updated!");
            }else {
                showResponce(404,"Not able to update!");
            }
        }else{
            showResponce(404,"Banner not exist!");
        }
        
    }else {
        showResponce(404,"Invalid Inputes!");
    }
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $banner = getBannerById($id);
        if(empty($banner)){
            showResponce(404,"No banner found.");
        }else{
            $result = deleteBanner($id);
            if($result){
                showResponce(200,"Banner deleted!");
            } else{
                showResponce(404,"Unable to delete");
            }
        }
    } 
    else {
        showResponce(404,"No banner found.");
    }
}
?>