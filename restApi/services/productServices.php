<?php
include_once '../config/dbConnection.php';

function getProducts(){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `products`";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $products=array();
        $products["products"] = array();
        $products["count"] = $query->rowCount();
        if($products["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $product=array(
                    "id" => $id,
                    "type" => $type,
                    "title" => $title,
                    "details" => $details,
                    "oldPrice" => $oldPrice,
                    "newPrice" => $newPrice,
                    "src" => $src
                );
                array_push($products["products"], $product);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $products;
}

function getProductById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `products` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $product=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "type" => $type,
                "title" => $title,  
                "details" => $details,
                "oldPrice" => $oldPrice,
                "newPrice" => $newPrice,
                "src" => $src
            );
            $product = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $product;
}

function addProduct($type,$title,$details,$oldPrice,$newPrice,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="INSERT INTO `products`(`type`, `title`, `details`, `oldPrice`,`newPrice`,`src`) VALUES ('$type','$title','$details','$oldPrice','$newPrice','$src')";
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

function updateProduct($id,$type,$title,$details,$oldPrice,$newPrice,$src){
    $database = new Database;
    $db = $database->getConnection();
    $sql ="UPDATE products SET `type` = '$type', `title` = '$title', `details` = '$details', `oldPrice` = '$oldPrice', `newPrice` = '$newPrice', `src` = '$src' WHERE `id` = '$id'";
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

function existProduct($type,$title){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `products` WHERE 'type'='$type' AND 'title'='$title'";
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

function deleteProduct($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "DELETE FROM `products` WHERE `id`='$id'";
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