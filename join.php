<?php
include './admin-panel/SDC.php';
// checking For a Post request
if(isset($_GET["personEmail"]) && $_GET["personName"] && $_GET["personMessage"]){
    $name = $email = $query = $msg = "";
    $email = test_input($_GET["personEmail"]);
    $name = test_input($_GET["personName"]);
    $query = test_input($_GET["personMessage"]);

    $subject = "$name want to Contact from aiwallpaper.online website.";
    $to = "learnbeyondthink@gmail.com";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email";
    $message = "Message from $name : $query." ;

    $selectQuery = "INSERT INTO contact (NAME, EMAIL, MESSAGE) values('$name', '$email', '$query')";
    $res = mysqli_query($connection, $selectQuery);
    if($res){        
        if(mail($to, $subject, $message, $headers)){
            echo 'We have been received your message. We will contact you as soon as possible.';
        }else{
            echo 'Something went wrong. Try again later';
        }
    } else{
        echo 'Something went wrong. Try again later';
    }
}
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars(($data));
    return $data;
}
?>