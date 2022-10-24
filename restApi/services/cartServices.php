<?php
include_once '../config/dbConnection.php';

function getCartByUserId($userid){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `cart` WHERE `userId` = {$userid}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $carts=array();
        $carts["carts"] = array();
        $carts["count"] = $query->rowCount();
        if($carts["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $cart=array(
                    "id" => $id,
                    "productId" => $productId,
                    "userId" => $userId,
                    "quantity" => $quantity                    
                );
                array_push($carts["carts"], $cart);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $carts;
}


function getCartById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `cart` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $cart=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "productId" => $productId,
                "userId" => $userId,
                "quantity" => $quantity
            );
            $cart = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $cart;
}

function addCart($productId,$userId,$quantity){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="INSERT INTO `cart`(`productId`, `userId`, `quantity`) VALUES ('$productId','$userId','$quantity')";
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

function existCart($productId,$userId){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `cart` WHERE `productId`=$productId AND `userId`=$userId";
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

function updateCart($id,$productId,$userId,$quantity){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="UPDATE cart SET `quantity` = '$quantity' WHERE `id` = '$id'";
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

function deleteCart($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "DELETE FROM `cart` WHERE `id`='$id'";
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