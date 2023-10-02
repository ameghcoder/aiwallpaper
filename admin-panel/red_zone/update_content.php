<?php
include '../SDC.php';

// this is a message sender that will send return message in json format
function msgSender($MSG, $FLAG){
    $msgArr = array(
        "msg" => $MSG, 
        "flag" => $FLAG
    );
    if($FLAG == 's'){
        echo json_encode($msgArr);
        exit;
    } else if($FLAG == 'e' || $FLAG == 'w'){
        echo json_encode($msgArr);
    }
}
if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['which'] == "recent"){
    $_query = "SELECT * FROM wallpaperaccess ORDER BY 1 DESC LIMIT 0, 10";
    $_res = mysqli_query($connection, $_query);
    $_num = mysqli_num_rows($_res);
    $_fetch_all_res = mysqli_fetch_all($_res);
    $_html = "";
    $_query_02 = "SELECT * FROM wallpaperaccessdesc ORDER BY 1 DESC LIMIT 0, 10";
    $_res_02 = mysqli_query($connection, $_query_02);
    $_num_02 = mysqli_num_rows($_res_02);
    $_fetch_all_res_02 = mysqli_fetch_all($_res_02);
    for($i = 0; $i < $_num; $i++){
        $content_size = filesize('../../jpeg/'.$_fetch_all_res[$i][2]);
        list($wid, $hei) = getimagesize('../../jpeg/'.$_fetch_all_res[$i][2]);
        $title = explode('/', $_fetch_all_res[$i][3])[2];
        $title = str_replace('-', ' ', $title);
        $cid = $i + 1;
        $_img_name = explode('.', $_fetch_all_res[$i][2])[0];
        $_html .= '<li data-cid='.$cid.' itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject" class="gallery-img-object">'.
        '<meta itemprop="fileFormat" content="image/jpeg">'.
        '<meta itemprop="keywords" content="'.$_fetch_all_res[$i][1].'">'.
        '<meta itemprop="description" content="'.$_fetch_all_res_02[$i][2].'">'.
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

    $_final_html = $_html;
    $_edit_page_name = "hm_wall.html";
    $_file_open_ = fopen($_edit_page_name, "w");
    fwrite($_file_open_, $_final_html);

    fclose($_file_open_);
    if(rename('../red_zone/' . $_edit_page_name, '../../component/' . $_edit_page_name)){
        msgSender("Edited Successfully", "s");
    } else {
        msgSender("Not Edited Successfully", "e");
    }
} else if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['which'] == 'sitemap'){
    $query_sitemap = "SELECT URL, PAGE FROM wallpaperaccess";
    $res_sitemap = mysqli_query($connection, $query_sitemap);
    $res_sitemap_num = mysqli_num_rows($res_sitemap);
    $res_sitemap_fetch = mysqli_fetch_all($res_sitemap);

    
    $start_xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
    $middle_xml = '';    
    $end_xml = '</urlset>';
    for($i = 0; $i < $res_sitemap_num; $i++){
        $res_image_name = explode('.', $res_sitemap_fetch[$i][0])[0];
        $middle_xml .=   '<url>
                            <loc>https://aiwallpaper.online'.$res_sitemap_fetch[$i][1].'</loc>
                            <image:image>
                            <image:loc>https://aiwallpaper.online/webp/'.$res_image_name.'.webp</image:loc>
                            </image:image>
                        </url>';
    }
    $_final_sitemap = $start_xml . $middle_xml . $end_xml;
    $_sitemap_name = 'imgSitemap.xml';
    $_file_open_sitemap = fopen($_sitemap_name, "w");

    fwrite($_file_open_sitemap, $_final_sitemap);

    fclose($_file_open_sitemap);
    if(rename('../red_zone/' . $_sitemap_name, '../../' . $_sitemap_name)){
        msgSender("Sitemap Updated Successfully", "s");
    } else {
        msgSender("Sitemap not updated Successfully", "e");
    }
}
?>