<?php

if($_SERVER['SERVER_NAME'] == "aiwallpaper.online"){
    include '../admin-panel/SDC.php';
    
    $_after = $_type = $_query = $_q = $_res = $_html = "";
    $_run = false;
    if($_SERVER['REQUEST_METHOD'] == "GET" && ($_GET["t"] == "srh" || $_GET["t"] == "ige")){
        $_after = $_GET["n"];
        $_type = $_GET["t"];
        $_q = $_GET["q"];
        $_q = str_replace('wallpaper', '', $_q);
        $_q = str_replace('full hd', '', $_q);
        $_q = trim($_q);
        $_query = "SELECT * FROM wallpaperaccess WHERE MATCH(tag, URL) AGAINST('$_q') ORDER BY 1 DESC LIMIT $_after, 10";
        $_res = mysqli_query($connection, $_query);
        $_num = mysqli_num_rows($_res);
        $_fetch_all_res = mysqli_fetch_all($_res);
        $_run = true;
    } else if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET["t"] == "hpe"){
        $_after = $_GET["n"];
        $_type = $_GET["t"];
        $_query = "SELECT * FROM wallpaperaccess ORDER BY 1 DESC LIMIT $_after, 10";   
        $_res = mysqli_query($connection, $_query);
        $_num = mysqli_num_rows($_res);
        $_fetch_all_res = mysqli_fetch_all($_res);
        $_run = true;
    }
    if($_run && $_num > 0){
        $_html = "";
        print_r(json_encode($_fetch_all_res));
        echo $_html;
    } else{
        echo false;
    }
}

?>