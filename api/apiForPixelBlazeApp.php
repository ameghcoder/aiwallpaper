<?php

// https://aiwallpaper.online/api/apiForPixelBlazeApp?singleTf={true}&relatedTf={true}&recentTf={true}&categoryTf={true}&id={0}&howMuchNeed={0}&startsFrom={0}&query={spider%man}
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
    $_single_wallpaper_tf = $_GET['singleTf'] ? true : false;
    $_related_tf = $_GET['relatedTf'] ? true : false;
    $_recent_tf = $_GET['recentTf'] ? true : false;
    $_category_tf = $_GET['categoryTf'] ? true : false;
    $_wall_id = $_GET['id'];
    $_how_much_need = $_GET['howMuchNeed'];
    $_starts_from_id = $_GET['startsFrom'];
    $_query_title = $_GET['query'];

    if ($_single_wallpaper_tf) {
        $_wall_id = $_GET["id"];

        $_queryDB = "SELECT * FROM wallpaperaccess WHERE id=$_wall_id";
        $_resDB = mysqli_query($connection, $_queryDB);
        $_resDB = mysqli_fetch_array($_resDB);

        echo json_encode($_resDB);
    } else if ($_related_tf) {
        $_query_title = $_GET["queryTitle"];
        $_how_much_need = $_GET["wallNeed"];

        $_queryDB = "SELECT * FROM wallpaperaccess WHERE MATCH(tag, URL) AGAINST('$_query_title') ORDER BY 1 DESC LIMIT $_starts_from_id, $_how_much_need";
        $_resDB = mysqli_query($connection, $_queryDB);
        $_resDB_Data = mysqli_fetch_all($_resDB);
        $_resDB_count = mysqli_num_rows($_resDB);

        if ($_resDB_count > 0) {
            echo json_encode($_resDB_Data);
        } else {
            echo json_encode(array("msg" => "End"));
        }

    } else if ($_recent_tf) {
        $_starts_from_id = $_GET["startsFrom"];
        $_how_much_need = $_GET["wallNeed"];

        if ($_starts_from_id == 'null') {
            $_queryDB_00 = "SELECT MAX(id) FROM wallpaperaccess";
            $_resDB_00 = mysqli_query($connection, $_queryDB_00);
            $_resDB_00 = mysqli_fetch_array($_resDB_00);
            $_starts_from_id = $_resDB_00['MAX(id)'];
            // echo json_encode($_resDB_00);
        }

        $_queryDB = "SELECT * FROM wallpaperaccess ORDER BY 1 DESC LIMIT $_starts_from_id, $_how_much_need";
        $_resDB = mysqli_query($connection, $_queryDB);
        $_resDB_Data = mysqli_fetch_all($_resDB);
        $_resDB_count = mysqli_num_rows($_resDB);

        if ($_resDB_count > 0) {
            echo json_encode($_resDB_Data);
        } else {
            echo json_encode(array("msg" => "End"));
        }
    } else if ($_category_tf) {
        $_query_title = $_GET["queryTitle"];
        $_how_much_need = $_GET["wallNeed"];
        $_starts_from_id = $_GET["startsFrom"];

        $_queryDB = "SELECT * FROM wallpaperaccess WHERE pw_category='$_query_title' ORDER BY 1 DESC LIMIT $_starts_from_id, $_how_much_need";
        $_resDB = mysqli_query($connection, $_queryDB);
        $_resDB_Data = mysqli_fetch_all($_resDB);
        $_resDB_count = mysqli_num_rows($_resDB);

        if ($_resDB_count > 0) {
            echo json_encode($_resDB_Data);
        } else {
            echo json_encode(array("msg" => "End"));
        }
    }

}

?>