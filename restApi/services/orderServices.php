<?php
include_once '../config/dbConnection.php';

function getOrders(){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `orders`";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $orders=array();
        $orders["orders"] = array();
        $orders["count"] = $query->rowCount();
        if($orders["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $order=array(
                    "id" => $id,
                    "userId" => $userId,
                    "productId" => $productId,
                    "quantity" => $quantity,
                    "address" => $address,
                    "price" => $price
                );
                array_push($orders["orders"], $order);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $orders;
}

function getOrderByUserId($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `orders` WHERE `userId` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $orders=array();
        $orders["orders"] = array();
        $orders["count"] = $query->rowCount();
        if($orders["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $order=array(
                    "id" => $id,
                    "userId" => $userId,
                    "productId" => $productId,
                    "quantity" => $quantity,
                    "address" => $address,
                    "price" => $price
                );
                array_push($orders["orders"], $order);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $orders;
}

function getOrderById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `orders` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $order=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "userId" => $userId,
                "productId" => $productId,
                "quantity" => $quantity,
                "address" => $address,
                "price" => $price
            );
            $order = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $order;
}

function addOrder($product,$userId,$address){
    $database = new Database;
    $db = $database->getConnection();
    foreach($product as $item){ 
        $sql ="INSERT INTO `orders`(`userId`, `productId`, `quantity`, `address`, `price`) VALUES ('$userId', '$item->id', '$item->quantity', '$address', '$item->newPrice')";
        try{
            $query = $db->prepare($sql);
            $result = $query->execute();
        }catch(PDOException $e){
            echo "Error: ".$e;
            die();
        }
        $database->disconnect();
    }
    return $result;    
}

function deleteOrder($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "DELETE FROM `orders` WHERE `id`='$id'";
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