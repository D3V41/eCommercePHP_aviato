<?php
function showResponce($resCode,$resMessage){
    if($resCode == 200){
        http_response_code($resCode);
        echo json_encode($resMessage);
    } else {
        http_response_code($resCode);
        echo json_encode(
            array("message" => $resMessage)
        ); 
    }
    
}
?>