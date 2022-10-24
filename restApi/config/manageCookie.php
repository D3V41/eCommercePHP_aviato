<?php
include_once '../services/userServices.php';
include_once '../httpresponce/encodedResponce.php';

function generateCookie($email,$password){
    $cookie_name = "seceret-of-the-world";
    $salt = substr (md5($password), 0, 2);
    $cookie = base64_encode ("$email:" . md5 ($password, $salt));
    setcookie ($cookie_name, $cookie,time() + (86400 * 2), "/");
}

function getCookie($email){
    $cookie_name = "seceret-of-the-world";
    $cookie = $_COOKIE[$cookie_name];
    $hash = base64_decode ($cookie);
    list($email, $hashed_password) = explode (':', $hash);
    $password = getUserPassword($email);
    if(!empty($password)){
        if (md5($password, substr(md5($password), 0, 2)) == $hashed_password) {
            return true;
        }else {
            return false;
        }
    } else{
        showResponce(404,"User not found");
    }   
}

function deleteCookie(){
    $cookie_name = "seceret-of-the-world";
    if (isset($_COOKIE[$cookie_name])) {
        unset($_COOKIE[$cookie_name]); 
        setcookie($cookie_name, null, -1, '/'); 
        return true;
    } else {
        return false;
    }
}
?>