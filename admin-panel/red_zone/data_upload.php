<?php

include_once '../SDC.php';

$_wallpaper = $_wallpaper_path = $_wallpaper_type = $_wallpaper_error = $_wallpaper_size = $_wallpaper_name = $_wallpaper_tags = $_wallpaper_description = "";
$_wFile_name = $_wFile_title = $_Img_extension = $_check_file_size = $done_task = "";
if($_SERVER['REQUEST_METHOD'] == "POST" || !empty($_FILES['wallpaperData'])){
    $_wallpaper = $_FILES['wallpaperData'];
    // wallpaper details variable
    $_wallpaper_path = test_input($_wallpaper['full_path']);
    $_wallpaper_temp_name = $_wallpaper['tmp_name'];
    $_wallpaper_type = $_wallpaper['type'];
    $_wallpaper_size = $_wallpaper['size'];
    $_wallpaper_error = $_wallpaper['error'];

    $_uploader_username = test_input($_POST['username']);
    $_wallpaper_name = test_input($_POST['wallpaperName']);
    $_wallpaper_tags = test_input($_POST['wallpaperTags']);
    $_wallpaper_description = test_input($_POST['wallpaperDescription']);

    list($original_width, $original_height) = getimagesize($_wallpaper_temp_name);

    // Now here we declare variables for file
    $_wFile_title = trim($_wallpaper_name); // Page Title Only
    $_wFile_name = str_replace(' ', '-', $_wFile_title); // This is File name and Wallpaper Name
    $_Img_extension = explode('/', $_wallpaper_type)[1];

    if($_Img_extension == "jpg" || $_Img_extension == "jfif"){
        $_Img_extension = "jpeg";
    }

    $URL = $_wFile_name . '.jpeg';
    $PAGE = '/image/' . $_wFile_name;

    if(!file_exists('../../image/' . $_wFile_name . '.php') && !file_exists('../../webp/' . $_wFile_name . '.webp') && !file_exists('../../jpeg/' . $_wFile_name . '.jpeg')){
        $_check_file_size = fileSizeChecker($_wallpaper_size);
        if($_check_file_size){
            if(webp500($_wFile_name, $_wallpaper_temp_name, $_Img_extension, $original_width, $original_height)){
                $done_task .= "Webp 500 image created,";
                if(originalImg($_wFile_name, $_wallpaper_temp_name, $_Img_extension, $original_width, $original_height)){
                    $done_task .= "Original image uploaded,";
                    // Add Data in Database
                    $query_01 = "INSERT INTO wallpaperaccess(tag, URL, PAGE) values('$_wallpaper_tags', '$URL', '$PAGE')";
                    $res_01 = mysqli_query($connection, $query_01);
                    if($res_01){
                        $query_02 = "SELECT id FROM wallpaperaccess WHERE URL='$URL'";
                        $res_02 = mysqli_query($connection, $query_02);
                        $res_02 = mysqli_fetch_row($res_02);
                        // we create a web 500, webp 1000 and upload original image and create page
                        $img_id = $res_02[0];

                        list($w_0, $h_0) = getimagesize('../../jpeg/' . $_wFile_name . '.jpeg');
                        $image_file_size_in_mb = filesize("../../jpeg/" . $_wFile_name . '.jpeg');
                        $image_file_size_in_mb = fileSizeInMB($image_file_size_in_mb);

                        $_wall_desc = $_wallpaper_description . '. Original wallpaper dimension is '. $w_0 .'×'. $h_0 .'px, file size is '.$image_file_size_in_mb.'.';
                        $query_03 = "INSERT INTO wallpaperaccessdesc(wall_id, wall_desc) values($img_id, '$_wall_desc')";
                        $res_03 = mysqli_query($connection, $query_03);
                        if($res_03){
                            if(createPage($_wallpaper_tags, $_wallpaper_description, $_wFile_name, $_wallpaper_name, $img_id)){
                                $done_task .= "Page Created Successfully";
                                msgSender($done_task, "s");
                            } else{
                                $unlink_img_01 = "../../webp/" . $_wFile_name .".webp";
                                $unlink_img_02 = "../../jpeg/" . $_wFile_name .".jpeg";
                                if(unlink($unlink_img_01) && unlink($unlink_img_02)){
                                    msgSender("Failed to add in db and Data rollbacked", "w");
                                } else{
                                    msgSender("Data not be rollbacked, you have to delete data manually, delete webp and jpeg image", "w");
                                }
                            }
                        } else{
                            $unlink_img_01 = "../../webp/" . $_wFile_name .".webp";
                            $unlink_img_02 = "../../jpeg/" . $_wFile_name .".jpeg";
                            if(unlink($unlink_img_01) && unlink($unlink_img_02)){
                                msgSender("Failed to add in db and Data rollbacked", "w");
                            } else{
                                msgSender("Data not be rollbacked, you have to delete data manually, delete webp and jpeg image", "w");
                            }
                        }
                    }else{
                        $unlink_img_01 = "../../webp/" . $_wFile_name .".webp";
                        $unlink_img_02 = "../../jpeg/" . $_wFile_name .".jpeg";
                        if(unlink($unlink_img_01) && unlink($unlink_img_02)){
                            msgSender("Failed to add in db and Data rollbacked", "w");
                        } else{
                            msgSender("Data not be rollbacked, you have to delete data manually, delete webp and jpeg image", "w");
                        }
                    }
                } else{
                    $unlink_img_01 = "../../webp/" . $_wFile_name .".webp";
                    if(unlink($unlink_img_01)){
                        msgSender("Data rollbacked", "w");
                    } else{
                        msgSender("Data not be rollbacked, you have to delete data manually", "w");
                    }
                }
            }
        }
    } else{
        msgSender("Change the file name this file name is already exists", "w");
    }
    
    // echo $_Img_extension;
}

// convert a image into webp format and resize at 500px
function webp500($RawImgName, $OldImg, $ext, $wid, $hei){
    $NewImg = "../../webp/" . $RawImgName .'.webp';

    $wantedSize = 500;
    $newWid = $newHei = "";

    // Creating Source Image
    $sourceImage = sourceImg($OldImg, $ext);
    if(!$sourceImage){
        msgSender("Enter a valid Image or this type of image not supported yet or Call the developer.", "w");
        return false;
    } else{
        // calculate size
        if($wid < $wantedSize){
            $newWid = $wid;
            $newHei = $hei;
        } else{
            $newWid = $wantedSize;
            $newHei = ($hei * $newWid)/$wid; 
        }
    
        $BlankImage = imagecreatetruecolor($newWid, $newHei);
        if($BlankImage){
            if(imagecopyresized($BlankImage, $sourceImage, 0, 0, 0, 0, $newWid, $newHei, $wid, $hei)){
                imagedestroy($sourceImage);
                if(imagewebp($BlankImage, $NewImg, 80)){
                    imagedestroy($BlankImage);
                    return true;
                } else{
                    msgSender("Image not Converted in webp-500. Call the developer.", "w");
                    return false;
                }
            } else{
                msgSender("Image copy resized function is not working for webp-500. Call the developer.", "w");
                return false;
            }
        } else{
            msgSender("Image Create True Color function is not working for webp-500. Call the developer.", "w");
            return false;
        }
    }
}

// convert a image into jpeg for download
function originalImg($RawImgName, $OldImg, $ext, $wid, $hei){
    $NewImg = "../../jpeg/" . $RawImgName .'.jpeg';

    // Creating Source Image
    $sourceImage = sourceImg($OldImg, $ext);
    if(!$sourceImage){
        msgSender("Enter a valid Image or this type of image not supported yet or Call the developer.", "w");
        return false;
    } else{
        $BlankImage = imagecreatetruecolor($wid, $hei);
        if($BlankImage){
            if(imagecopyresized($BlankImage, $sourceImage, 0, 0, 0, 0, $wid, $hei, $wid, $hei)){
                imagedestroy($sourceImage);
                if(imagejpeg($BlankImage, $NewImg, 80)){
                    imagedestroy($BlankImage);
                    return true;
                } else{
                    msgSender("Image jpeg function doesn't work in orignial image function. Call the developer.", "w");
                    return false;
                }
            } else{
                msgSender("Image Copy Resized function doesn't work in original Image function. Call the developer.", "w");
                return false;
            }
        } else{
            msgSender("Image create true color function doesn't work in original Image function. Call the developer.", "w");        
            return false;
        }
    }
}

function fileSizeInMB($size){
    if($size > 1000 && $size < 1000000){
        return round($size / 1000) . 'KB';
    } else if ($size > 0 && $size < 1000){
        return round($size / 1000) . 'Byte';
    } else if($size > 1000000){
        return round($size / 1000000) . 'MB';
    }
}

function createPage($keywordsLine, $description, $RawImageName, $title, $imgID){
    $oriURL = $RawImageName . '.jpeg';

    $wid = $hei = $image_file_size_in_mb = "";
    list($wid, $hei) = getimagesize("../../jpeg/" . $oriURL);
    
    $image_file_size_in_mb = filesize("../../jpeg/" . $oriURL);
    $image_file_size_in_mb = fileSizeInMB($image_file_size_in_mb);

    $_wallpaper = "";
    $_wallpaper = str_replace('full hd', '', $title);
    $_wallpaper = str_replace('hd', '', $_wallpaper);
    $_wallpaper = str_replace('wallpaper', '', $_wallpaper);
    $_wallpaper = str_replace('4k', '', $_wallpaper);
    $_wallpaper = str_replace('image', '', $_wallpaper);
    $_wallpaper = str_replace('android', '', $_wallpaper);
    $_wallpaper = str_replace('iphone', '', $_wallpaper);
    $_wallpaper = str_replace('iPhone', '', $_wallpaper);

    $tags = "";
    $tags = explode(',', trim($keywordsLine));
    $li_html = "";
    for($i = 0; $i < count($tags); $i++){
        $li_html .= '<a href="/search?wallpaper='.$tags[$i].'" rel="tag">'.$tags[$i].'</a>';
    }

    $pageName = $RawImageName . '.php';
    $fh = fopen($pageName, "w");
    $html = '<!DOCTYPE html>'.
    '<html lang="en">'.
    '<head>'.
    '<meta charset="UTF-8">'.
    '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.
    '<meta name="viewport" content="width=device-width, initial-scale=1.0">'.
    '<meta name="keywords" content="'.$keywordsLine.'">'.
    '<meta name="description" content="'.$description.'. Original wallpaper dimension is '.$wid.'×'.$hei.'px, file size is '.$image_file_size_in_mb.'.">'.
    '<meta itemprop="name" content="'.$title.'">'.
    '<meta itemprop="description" content="'.$description.'. Original wallpaper dimension is '.$wid.'×'.$hei.'px, file size is '.$image_file_size_in_mb.'.">'.
    '<meta itemprop="image" content="https://aiwallpaper.online/jpeg/'.$oriURL.'">'.
    '<meta property="og:title" content="'.$title.'">'.
    '<meta property="og:url" content="https://aiwallpaper.online/image/'.$RawImageName.'">'.
    '<meta property="og:description" content="'.$description.'. Original wallpaper dimension is '.$wid.'×'.$hei.'px, file size is '.$image_file_size_in_mb.'.">'.
    '<meta property="og:image" content="https://aiwallpaper.online/jpeg/'.$oriURL.'" />'.
    '<meta property="og:image:secure_url" content="https://aiwallpaper.online/jpeg/'.$oriURL.'" />'.
    '<meta property="og:image:type" content="image/jpeg" />'.
    '<meta property="og:image:alt" content="'.$title.'" /><?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'h_links.html'); ?>".
    '<link rel="canonical" href="https://aiwallpaper.online/image/'.$RawImageName.'" />'.
    '<title>'.$title.'</title>'.
    '</head>'.
    '<body>'.
    '<div class="ai-container">'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'header.html'); ?>".
    '<main class="ai-main" id="main-content">'.
    '<div class="heading">'.
    '<h1>'.$title.'</h1>'.
    '</div>'.
    '<section class="preview-image-box" itemprop="primaryImageOfPage" itemscope="" itemtype="http://schema.org/ImageObject">'.
    '<div class="pib-inside">'.
    '<div class="pib-left">'.
    '<meta itemprop="representativeOfPage" content="true">'.
    '<meta itemprop="isFamilyFriendly" content="true">'.
    '<figure class="img-box">'.
    '<img itemprop="contentUrl" src="/webp/'.$RawImageName.'.webp" alt="'.$title.'">'.
    '<br>'.
    '<figcaption>'.$title.'</figcaption>'.
    '</figure>'.
    '<div class="tag-list">'.
    $li_html .
    '</div>'.
    '<meta itemprop="keywords" content="'.$keywordsLine.'">'.
    '<meta itemprop="description" content="'.$description.'. Original wallpaper dimension is '.$wid.'×'.$hei.'px, file size is '.$image_file_size_in_mb.'">'.
    '<link itemprop="thumbnail" href="https://aiwallpaper.online/jpeg/'.$oriURL.'">'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>".
    '</div>'.
    '<div class="pib-right">'.
    '<div class="img-btns">'.
    '<div class="more-info">'.
    '<span>'.
    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">'.
    '<path fill="currentColor" d="M4.5,5 C3.67157288,5 3,5.67157288 3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,9.5 C21,8.67157288 20.3284271,8 19.5,8 L14,8 C12.8954305,8 12,7.1045695 12,6 C12,5.44771525 11.5522847,5 11,5 L4.5,5 Z M4.5,4 L11,4 C12.1045695,4 13,4.8954305 13,6 C13,6.55228475 13.4477153,7 14,7 L19.5,7 C20.8807119,7 22,8.11928813 22,9.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 C2,5.11928813 3.11928813,4 4.5,4 Z"></path>'.
    '</svg> File Size : '.$image_file_size_in_mb.'</span>'.
    '<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">'.
    '<path fill="currentColor" d="M8.29289322,15 L3.5,15 C3.22385763,15 3,14.7761424 3,14.5 C3,14.2238576 3.22385763,14 3.5,14 L9.5,14 C9.77614237,14 10,14.2238576 10,14.5 L10,20.5 C10,20.7761424 9.77614237,21 9.5,21 C9.22385763,21 9,20.7761424 9,20.5 L9,15.7071068 L3.85355339,20.8535534 C3.65829124,21.0488155 3.34170876,21.0488155 3.14644661,20.8535534 C2.95118446,20.6582912 2.95118446,20.3417088 3.14644661,20.1464466 L8.29289322,15 Z M15.7071068,9 L20.5,9 C20.7761424,9 21,9.22385763 21,9.5 C21,9.77614237 20.7761424,10 20.5,10 L14.5,10 C14.2238576,10 14,9.77614237 14,9.5 L14,3.5 C14,3.22385763 14.2238576,3 14.5,3 C14.7761424,3 15,3.22385763 15,3.5 L15,8.29289322 L20.1464466,3.14644661 C20.3417088,2.95118446 20.6582912,2.95118446 20.8535534,3.14644661 C21.0488155,3.34170876 21.0488155,3.65829124 20.8535534,3.85355339 L15.7071068,9 Z"></path>'.
    '</svg> Size : '.$wid.'×'.$hei.'</span>'.
    '</div>'.
    '<a href="/jpeg/'.$oriURL.'" download="aiwallpaper_online-'.$title.'">Download</a>'.
    '<a href="https://www.wallpaper-access.com" style="background-color: var(--back-clr-lite) !important;color:white!important;" target="_blank">Desktop Wallpapers</a>'.
    '<div>'.
    '<strong>Share on :</strong>'.
    '<a title="Share on Twitter" href="https://twitter.com/share?url=https://aiwallpaper.online/image/'.$RawImageName.'"><i class="icon-size icon-settings twitter"></i></a>'.
    '<a title="Share on Whatsapp" href="https://api.whatsapp.com/send?text=https://aiwallpaper.online/image/'.$RawImageName.'"><i class="icon-size icon-settings whatsapp"></i></a>'.
    '<a title="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://aiwallpaper.online/image/'.$RawImageName.'"><i class="icon-size icon-settings facebook"></i></a>'.
    '</div>'.
    '</div>'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'hori-ads.html'); ?>".
    '</div>'.
    '</div>'.
    '</section>'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>".
    '<section class="ai-image-gallery">'.
    '<?php $_wallpaper = "'.$_wallpaper.'"; include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'relative.php'); ?>".
    '</section>'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>".
    '</main>'.
    '<?php include($'.'_SERVER'."['DOCUMENT_ROOT'] . '/component/' . 'footer.html'); ?>".
    '</body>'.
    '</html>';

    fwrite($fh, $html);
    fclose($fh);
    $msg = rename('../red_zone/' . $pageName, '../../image/' . $pageName);
    if($msg){
        return true;
    } else{
        return false;
    }
}

// image size checker, to check image is too small or too big
function fileSizeChecker($fileSize){
    $MAX_FILE_SIZE = 10485760;
    if($fileSize > $MAX_FILE_SIZE){
        msgSender("Image is too big", 'w');
        exit;
    } else if($fileSize < 20480){
        msgSender("Image is too small", 'w');
        exit;
    } else{
        return true;
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

function sourceImg($OriginalImg, $extension){
    if($extension == 'jpg' || $extension == 'jfif' || $extension == 'jif' || $extension == 'jpeg'){
        return @imagecreatefromjpeg($OriginalImg);
    } else if($extension == 'png'){
        return @imagecreatefrompng($OriginalImg);
    } else if($extension == 'webp'){
        return @imagecreatefromwebp($OriginalImg);
    } else if($extension == 'wbmp'){
        return @imagecreatefromwbmp($OriginalImg);
    } else if($extension == 'xbm'){
        return @imagecreatefromxbm($OriginalImg);
    } else if($extension == 'bmp'){
        return @imagecreatefrombmp($OriginalImg);    
    } else{
        return @imagecreatefromjpeg($OriginalImg);    
    }
}

?>