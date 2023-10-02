<?php

include_once("./SDC.php");

if ($_SERVER['REQUEST_METHOD'] == "GET" && ($_GET["q"] == "rcnt" || $_GET["q"] == "pplr" || $_GET["q"] == "aig" || $_GET["q"] == "rltv" || $_GET["q"] == "ctgr" || $_GET["q"] == "wall")) {

    // Recent Wallpaper
    // Popular Wallpaper
    // Ai Generated Wallpaper
    // Relative Wallpaper
    // Category of Wallpaper
    // Single Wallpaper Detail using id

} else {
    header('HTTP/1.1 404 Not Found');
}

?>