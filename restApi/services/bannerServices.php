<?php
include_once '../config/dbConnection.php';

function getBanners(){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `banners`";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $banners=array();
        $banners["banners"] = array();
        $banners["count"] = $query->rowCount();
        if($banners["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $banner=array(
                    "id" => $id,
                    "name" => $name,
                    "title" => $title,
                    "subtitle" => $subtitle,
                    "src" => $src
                );
                array_push($banners["banners"], $banner);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $banners;
}

function getBannerById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `banners` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $banner=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "name" => $name,
                "title" => $title,
                "subtitle" => $subtitle,
                "src" => $src
            );
            $banner = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $banner;
}

function addBanner($name,$title,$subtitle,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="INSERT INTO `banners`(`name`, `title`, `subtitle`,`src`) VALUES ('$name','$title','$subtitle','$src')";
    try{
        $query = $db->prepare($sql);
        $result = $query->execute();
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $result;
}

function updateBanner($id,$name,$title,$subtitle,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="UPDATE banners SET `name` = '$name', `title` = '$title', `subtitle` = '$subtitle', `src` = '$src' WHERE `id` = '$id'";
    try{
        $query = $db->prepare($sql);
        $result = $query->execute();
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $result;
}

function existBanner($name,$title){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `banners` WHERE 'name'='$name' AND 'title'='$title'";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->rowCount();

    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $result;
}

function deleteBanner($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "DELETE FROM `banners` WHERE `id`='$id'";
    try{
        $query = $db->prepare($sql);
        $result = $query->execute();
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $result;
}

?>