<?php
include_once '../SDC.php';

if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['delete_id'] != ""){
    $_delete_id = test_input($_GET['delete_id']);
    $query_02 = "SELECT URL FROM wallpaperaccess WHERE id=$_delete_id";
    $res_02 = mysqli_query($connection, $query_02);
    $res_02 = mysqli_fetch_row($res_02);
    $name_00 = explode('.', $res_02[0])[0];
    if(deletePage($name_00)){
        if(deleteWall($res_02[0])){
            if(deleteDB($_delete_id)){
                msgSender("Wallpaper, DB and Page is deleted successfully.", "s");
            }
        }
    }
}

function deletePage($name){
    if(unlink('../../image/'.$name.'.php')){
        return true;
    } else{
        msgSender("Delete Page function is not working.", "w");
    }
}
function deleteWall($URL){
    $_URL = explode('.', $URL)[0];
    if(unlink('../../jpeg/'.$URL)){
        if(unlink('../../webp/'.$_URL.'.webp')){
            return true;
        } else{            
            msgSender("Delete Wall function is not working for webp folder, check it now.", "w");
        }
    } else{
        msgSender("Delete Wall function is not working for jpeg folder, check it now.", "w");
    }
}
function deleteDB($id){
    global $connection;
    $query = "DELETE FROM wallpaperaccess WHERE id=$id";
    if(mysqli_query($connection, $query)){
        $query_01 = "DELETE FROM wallpaperaccessdesc WHERE wall_id=$id";
        if(mysqli_query($connection, $query_01)){
            return true;
        } else{
            msgSender("Mysqli Query function is not working for wa desc database. check it now", "w");
        }
    } else{
        msgSender("Mysqli Query function is not working for wa database. check it now", "w");
    }
}
// this is a message sender that will send return message in json format
function msgSender($MSG, $FLAG){
    $msgArr = array(
        "msg" => $MSG, 
        "flag" => $FLAG
    );
    if($FLAG == 's'){
        echo json_encode($msgArr);
        exit;
    } else if($FLAG == 'w'){
        echo json_encode($msgArr);
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars(($data));
    return $data;
}
?>