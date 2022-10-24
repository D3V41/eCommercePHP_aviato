<?php
include_once '../config/dbConnection.php';

function getAllUsers(){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users`";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $allusers=array();
        $allusers["users"] = array();
        $allusers["count"] = $query->rowCount();
        if($allusers["count"]>0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $user=array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "password" => $password,
                    "shipping_address" => $shipping_address
                );
                array_push($allusers["users"], $user);
            }
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $allusers;
}

function getUserById($id){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users` WHERE `id` = {$id}";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $user=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "shipping_address" => $shipping_address
            );
            $user = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $user;
}

function registerUser($name,$email,$password,$shipping_address){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "INSERT INTO `users`(`email`, `password`, `name`, `shipping_address`) VALUES ('$email','$password','$name','$shipping_address')";
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

function loginUser($email,$password){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users` WHERE email='$email' AND password='$password'";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $user=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "shipping_address" => $shipping_address
            );
            $user = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $user;
}

function updateUserInfo($id,$name,$email,$password,$shipping_address){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "UPDATE users SET `name` = '$name', `email` = '$email', `password` = '$password', `shipping_address` = '$shipping_address' WHERE `id` = '$id'";
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

function existUser($email){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users` WHERE email='$email'";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $user=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "shipping_address" => $shipping_address
            );
            $user = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $user;
}

function getUserPassword($email){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users` WHERE email='$email'";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $key;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $key = $password;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $key;
}

function getProfile($email){
    $database = new Database;
    $db = $database->getConnection();
    $sql = "SELECT * FROM `users` WHERE email='$email'";
    try{
        $query = $db->prepare($sql);
        $query->execute();
        $user=array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $output=array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "shipping_address" => $shipping_address
            );
            $user = $output;
        }
    }catch(PDOException $e){
        echo "Error: ".$e;
        die();
    }
    $database->disconnect();
    return $user;
}

?>