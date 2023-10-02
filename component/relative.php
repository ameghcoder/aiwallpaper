<ul itemscope itemtype="http://schema.org/ImageGallery" class="gallery">
    <?php
        include '../admin-panel/SDC.php';
       
        $_query = "SELECT * FROM wallpaperaccess WHERE MATCH(tag, URL) AGAINST('$_wallpaper') ORDER BY 1 DESC LIMIT 0, 5";
        $_res = mysqli_query($connection, $_query);
        $_num = mysqli_num_rows($_res);
        $_fetch_all_res = mysqli_fetch_all($_res);
        $_html = "";
        $mid_html = "";
        for($i = 0; $i < $_num; $i++){
            $_id = $_fetch_all_res[$i][0];
            $_query_02 = "SELECT wall_desc FROM wallpaperaccessdesc WHERE wall_id=$_id";
            $_res_02 = mysqli_query($connection, $_query_02);
            $_fetch_all_res_02 = mysqli_fetch_row($_res_02);
            $content_size = filesize('../jpeg/'.$_fetch_all_res[$i][2]);
            list($wid, $hei) = getimagesize('../jpeg/'.$_fetch_all_res[$i][2]);
            $title = explode('/', $_fetch_all_res[$i][3])[2];
            $title = str_replace('-', ' ', $title);
            $cid = $i + 1;
            $_wallpaper = trim($_wallpaper);
            if($i == $_num - 1){
                $mid_html = 'data-query="'.$_wallpaper.'"';
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
<div data-type="ige" class="loader-gif-on-scroll" style="padding: 20px;display:flex;align-items:center;justify-content:center;">
    <img class="loader-gif" style="width:40px;height:40px;display:none;" src="/assets/loader.gif" alt="loader gif">
</div>