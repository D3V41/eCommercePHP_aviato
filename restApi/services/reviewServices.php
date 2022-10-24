<?php
include_once '../config/dbConnection.php';

function getReviewsByProductId($productid){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `reviews` WHERE `productId` = {$productid}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $reviews=array();
        $reviews["reviews"] = array();
        $reviews["count"] = $query->rowCount();
        if($reviews["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $review=array(
                    "id" => $id,
                    "productId" => $productId,
                    "userId" => $userId,
                    "date" => $date,
                    "username" => $username,
                    "review" => $review,
                    "src" => $src
                );
                array_push($reviews["reviews"], $review);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $reviews;
}

function getReviewById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `reviews` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $review=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "productId" => $productId,
                "userId" => $userId,
                "date" => $date,
                "username" => $username,
                "review" => $review,
                "src" => $src
            );
            $review = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $review;
}

function addReview($productId,$userId,$date,$username,$review,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="INSERT INTO `reviews`(`productId`, `userId`, `date`, `username`,`review`,`src`) VALUES ('$productId','$userId','$date','$username','$review','$src')";
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

function existReview($productId,$userId){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `reviews` WHERE `productId`=$productId AND `userId`=$userId";
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

function updateReview($id,$productId,$userId,$date,$username,$review,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="UPDATE reviews SET `date` = '$date', `review` = '$review', `src` = '$src' WHERE `id` = '$id'";
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

function deleteReview($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "DELETE FROM `reviews` WHERE `id`='$id'";
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