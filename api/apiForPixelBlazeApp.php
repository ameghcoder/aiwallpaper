<?php

// _tf means true_or_false

if ($_SERVER['SERVER_NAME'] == 'aiwallpaper.online' && ($_SERVER["REQUEST_METHOD"] == "GET")) {
    include '../admin-panel/SDC.php';

    $_wall_id = 0;
    $_how_much_need = 0;
    $_starts_from_id = 0;
    $_query_title = "";
    $_single_wallpaper_tf = false;
    $_related_tf = false;
    $_recent_tf = false;
    $_category_tf = false;

    // Default values
    $_single_wallpaper_tf = $_GET['singleTf'];
    $_related_tf = $_GET['relatedTf'];
    $_recent_tf = $_GET['recentTf'];
    $_category_tf = $_GET['categoryTf'];
    $_wall_id = $_GET['id'];
    $_how_much_need = $_GET['howMuchNeed'];
    $_starts_from_id = $_GET['startsFrom'];
    $_query_title = $_GET['query'];

    if ($_single_wallpaper_tf) {
        $_wall_id = $_GET["id"];

        $_queryDB = "SELECT * FROM wallpaperaccess WHERE id=$_wall_id";
        $_resDB = mysqli_query($connection, $_queryDB);

        echo json_encode($_resDB);
    } else if ($_related_tf) {
        $_query_title = $_GET["queryTitle"];
        $_how_much_need = $_GET["wallNeed"];
    } else if ($_recent_tf) {
        $_starts_from_id = $_GET["startsFrom"];
        $_how_much_need = $_GET["wallNeed"];
    } else if ($_category_tf) {
        $_query_title = $_GET["queryTitle"];
        $_how_much_need = $_GET["wallNeed"];
    }

}

?>