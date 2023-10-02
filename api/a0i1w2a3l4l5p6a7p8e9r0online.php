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
        // $_q = str_replace('created', '', $_q);
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
        for($i = 0; $i < $_num; $i++){
            $_id = $_fetch_all_res[$i][0];
            $_query_02 = "SELECT wall_desc FROM wallpaperaccessdesc WHERE wall_id=$_id";
            $_res_02 = mysqli_query($connection, $_query_02);
            $_fetch_all_res_02 = mysqli_fetch_row($_res_02);
            $content_size = filesize('../jpeg/'.$_fetch_all_res[$i][2]);
            list($wid, $hei) = getimagesize('../jpeg/'.$_fetch_all_res[$i][2]);
            $title = explode('/', $_fetch_all_res[$i][3])[2];
            $title = str_replace('-', ' ', $title);
            $cid = $_after + $i + 1;
            $_img_name = explode('.', $_fetch_all_res[$i][2])[0];
            $_html .= '<li data-cid="'.$cid.'" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject" class="gallery-img-object">'.
                '<meta itemprop="fileFormat" content="image/jpeg">'.
                '<meta itemprop="keywords" content="'.$_fetch_all_res[$i][1].'">'.
                '<meta itemprop="description" content="'.$_fetch_all_res_02[0].'">'.
                '<meta itemprop="contentSize" content="'.$content_size.'">'.
                '<div class="res">'.
                '<span itemprop="width" itemscope="" itemtype="http://schema.org/QuantitativeValue">'.
                '<span itemprop="value">'.$wid.'</span>'.
                '<meta itemprop="unitText" content="px">'.
                '</span>'.
                'x'.
                '<span itemprop="height" itemscope="" itemtype="http://schema.org/QuantitativeValue">'.
                '<span itemprop="value">'.$hei.'</span>'.
                '<meta itemprop="unitText" content="px">'.
                '</span>px'.
                '</div>'.
                '<figure>'.
                '<a itemprop="url" href="'.$_fetch_all_res[$i][3].'">'.
                '<img itemprop="contentUrl" alt="'.$title.'" title="'.$title.'" class="lazy" src="/assets/layzload.webp" data-src="/webp/'.$_img_name.'.webp">'.
                '</a>'.
                '<figcaption itemprop="caption">'.$title.'</figcaption>'.
                '</figure>'.
                '</li>';
        }
        echo $_html;
    } else{
        echo false;
    }
}

?>