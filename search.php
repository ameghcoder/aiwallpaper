<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="ai wallpaper, android wallpaper, iphone wallpaper, 4k wallpaper, 4k image, 2k, 4k, 8k, wallpapers, 1080p, anime wallpaper, midjourney wallpaper, trending wallpaper">
    <?php
    $actual_link = "https://aiwallpaper.online$_SERVER[REQUEST_URI]";
    $actual_link = htmlspecialchars($actual_link);
    $actual_link =trim($actual_link);
    $parts = parse_url($actual_link);
    parse_str($parts['query'], $query);
    
    echo '<link rel="canonical" href="'.$actual_link.'" /><meta itemprop="name" content="'.ucfirst($query['wallpaper']).' >> AI Wallpapers"><meta name="twitter:title" content="'.ucfirst($query['wallpaper']).' >> AI Wallpapers"><title>'.ucfirst($query['wallpaper']).' >> AI Wallpapers</title>';
?>
    <meta name="description" content="Here you can search best android and iphone wallpaper. Enter your query here and you will get best results.">
    <meta itemprop="description" content="Here you can search best android and iphone wallpaper. Enter your query here and you will get best results.">
    <meta name="twitter:description" content="Here you can search best android and iphone wallpaper. Enter your query here and you will get best results.">
<?php include($_SERVER['DOCUMENT_ROOT'].'/component/'.'h_links.html'); ?>
</head>
<body>
    <div class="ai-container">
        <?php include($_SERVER['DOCUMENT_ROOT'].'/component/header.html'); ?>
        <main class="ai-main" id="main-content">
            <h1>Search result for : <?php echo $query['wallpaper']; ?></h1>
                           <div class="wide-ads-box" style="width: 100%;padding: 20px;border:1px solid #4a4a4a;" itemscope itemtype="http://schema.org/WPAdBlock">
     <!-- Yandex.RTB R-A-2336857-2 -->
<div id="yandex_rtb_R-A-2336857-2"></div>
<script>
  window.yaContextCb.push(()=>{ Ya.Context.AdvManager.render({"blockId":"R-A-2336857-2","renderTo":"yandex_rtb_R-A-2336857-2"}) })
</script>
 </div>
            <section class="ai-image-gallery">
                <ul itemscope itemtype="http://schema.org/ImageGallery" class="gallery">
                    <?php
                        include './admin-panel/SDC.php';
                        
                        $_search_keyword = "";
                        if($_SERVER['REQUEST_METHOD'] == "GET"){
                            $_search_keyword = $_GET['wallpaper'];
                            // $_search_keyword = str_replace('android', '', $_search_keyword);
                            $_search_keyword = str_replace('wallpaper', '', $_search_keyword);
                            $_search_keyword = str_replace('full hd', '', $_search_keyword);
                            // $_search_keyword = str_replace('iphone', '', $_search_keyword);
                        } else{
                             $currentPageUrl = "https://aiwallpaper.online/".$_SERVER["REQUEST_URI"]; 
                            $url_components = parse_url($currentPageUrl);
                            parse_str($url_components['query'], $params);
                            $_search_keyword = $params['wallpaper'];
                            $_search_keyword = htmlspecialchars($_search_keyword);
                            $_search_keyword =trim($_search_keyword);
                            $_search_keyword = str_replace('-', ' ', $_search_keyword);
                            $_search_keyword = str_replace('/', ' ', $_search_keyword);
                            $_search_keyword = str_replace('wallpaper', '', $_search_keyword);
                            $_search_keyword = str_replace('image', '', $_search_keyword);
                            $_search_keyword = str_replace('pic', '', $_search_keyword);
                            $_search_keyword = str_replace('picture', '', $_search_keyword);
                            $_search_keyword = str_replace('free', '', $_search_keyword);
                        }
                        $_query = "SELECT * FROM wallpaperaccess WHERE MATCH(tag, URL) AGAINST('$_search_keyword') ORDER BY 1 DESC LIMIT 0, 15";
                        $_res = mysqli_query($connection, $_query);
                        $_num = mysqli_num_rows($_res);
                        $_fetch_all_res = mysqli_fetch_all($_res);
                        $_html = $mid_html = "";
                        for($i = 0; $i < $_num; $i++){
                            $_id = $_fetch_all_res[$i][0];
                            $_query_02 = "SELECT wall_desc FROM wallpaperaccessdesc WHERE wall_id=$_id";
                            $_res_02 = mysqli_query($connection, $_query_02);
                            $_fetch_all_res_02 = mysqli_fetch_row($_res_02);
                            $content_size = filesize('./jpeg/'.$_fetch_all_res[$i][2]);
                            list($wid, $hei) = getimagesize('./jpeg/'.$_fetch_all_res[$i][2]);
                            $title = explode('/', $_fetch_all_res[$i][3])[2];
                            $title = str_replace('-', ' ', $title);
                            $cid = $i + 1;
                            if($i == $_num - 1){
                                $mid_html = 'data-query="'.$_search_keyword.'"';
                            }
                            $_img_name = explode('.', $_fetch_all_res[$i][2])[0];
                            $_html .= '<li data-cid="'.$cid.'" '.$mid_html.' itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject" class="gallery-img-object">'.
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
                    ?>
                    
                </ul>
                <div data-type="srh" class="loader-gif-on-scroll" style="padding: 20px;display:flex;align-items:center;justify-content:center;">
                    <img class="loader-gif" style="width:40px;height:40px;display:none;" src="/assets/loader.gif" alt="loader gif">
                </div>
            </section>
        </main>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/component/footer.html'); ?>
    </div>
</body>
</html>