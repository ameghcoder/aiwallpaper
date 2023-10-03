<?php

include_once '../SDC.php';

$_update_title = $_update_description = $_update_tags = $_update_category = $_wall_id = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $_update_title = $_POST['update_title'];
    $_update_description = $_POST['update_description'];
    $_update_tags = $_POST['update_tags'];
    $_update_category = $_POST['update_category'];
    $_wall_id = $_POST['wall_id'];

    $_update_name = test_input($_update_title);
    $_update_name = str_replace('-', ' ', $_update_name);

    $query_01 = "SELECT URL FROM wallpaperaccess WHERE id=$_wall_id";
    $res_01 = mysqli_query($connection, $query_01);
    $res_01 = mysqli_fetch_row($res_01);
    $_db_wall_name = explode('.', $res_01[0])[0];
    $_db_wall_ext = explode('.', $res_01[0])[1];
    if ($_db_wall_name == $_update_title) {
        if (setData($_update_tags, $_wall_id, $_update_category)) {
            if (setDesc($_update_description, $_wall_id)) {
                if (createPage($_update_tags, $_update_description, $_update_title, $_update_name, $_wall_id)) {
                    msgSender("Page edited successfully.", "s");
                } else {
                    msgSender("Create Page is not working, An Error Occurred", "w");
                }
            } else {
                msgSender("Set Desc is not working, An Error Occurred", "w");
            }
        } else {
            msgSender("Set Data is not working, An Error Occurred", "w");
        }
    } else {
        if (renameFunc($_update_title, $_wall_id)) {
            if (setData($_update_tags, $_wall_id, $_update_category, $_update_title . '.' . $_db_wall_ext, '/image/' . $_update_title)) {
                if (setDesc($_update_description, $_wall_id)) {
                    if (createPage($_update_tags, $_update_description, $_update_title, $_update_name, $_wall_id)) {
                        msgSender("Page edited successfully.", "s");
                    } else {
                        msgSender("Create Page is not working, in update title, An Error Occurred", "w");
                    }
                } else {
                    msgSender("Set Desc is not working, in update title, An Error Occurred", "w");
                }
            } else {
                msgSender("Set Data is not working, in update title, An Error Occurred", "w");
            }
        }
    }
    // echo $_Img_extension;
}

function renameFunc($_new_title, $_id)
{
    global $connection;
    $_old_title = $_old_title_wext = $_ext = "";
    $_query = "SELECT URL FROM wallpaperaccess WHERE id=$_id";
    $_res = mysqli_query($connection, $_query);
    $_res = mysqli_fetch_row($_res);
    if ($_res != null || $_res) {
        $_old_title = $_res[0];
        $_old_title_wext = explode('.', $_res[0])[0];
        $_ext = explode('.', $_res[0])[1];
    }
    if (rename('../../webp/' . $_old_title_wext . '.webp', '../../webp/' . $_new_title . '.webp')) {
        if (rename('../../jpeg/' . $_old_title, '../../jpeg/' . $_new_title . '.' . $_ext)) {
            if (rename('../../image/' . $_old_title_wext . '.php', '../../image/' . $_new_title . '.php')) {
                return true;
            } else {
                msgSender("Rename function image folder is not working.", "w");
            }
        } else {
            msgSender("Rename function for jpeg is not working.", "w");
        }
    } else {
        msgSender("Rename function for webp is not working.", "w");
    }
}

function setData($_tag, $id, $_category, $_URL = '', $_PAGE = '')
{
    global $connection;
    if ($_URL == '' || $_PAGE == '') {
        $query = "UPDATE wallpaperaccess SET tag='$_tag', pw_category='$_category' WHERE id=$id";
    } else {
        $query = "UPDATE wallpaperaccess SET tag='$_tag', pw_category='$_category', URL='$_URL', PAGE='$_PAGE' WHERE id=$id";
    }
    $res = mysqli_query($connection, $query);
    if ($res) {
        return true;
    } else {
        return false;
    }
}
function setDesc($_description, $_wall_id)
{
    global $connection;
    $query = $res = "";
    $_get_query = "SELECT * FROM wallpaperaccessdesc WHERE wall_id=$_wall_id";
    $_get_res = mysqli_query($connection, $_get_query);
    $_get_res = mysqli_fetch_row($_get_res);
    if ($_get_res) {
        $query = "UPDATE wallpaperaccessdesc SET wall_desc='$_description' WHERE wall_id=$_wall_id";
        $res = mysqli_query($connection, $query);
    } else {
        $query = "INSERT INTO wallpaperaccessdesc(wall_id, wall_desc) VALUES ($_wall_id, '$_description')";
        $res = mysqli_query($connection, $query);
    }
    if ($res) {
        return true;
    } else {
        return false;
    }
}

function fileSizeInMB($size)
{
    if ($size > 1000 && $size < 1000000) {
        return ($size / 1000) . 'KB';
    } else if ($size > 0 && $size < 1000) {
        return ($size / 1000) . 'Byte';
    } else if ($size > 1000000) {
        return ($size / 1000000) . 'MB';
    }
}

function createPage($keywordsLine, $description, $RawImageName, $title, $imgID)
{
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
    for ($i = 0; $i < count($tags); $i++) {
        $li_html .= '<a href="/search?wallpaper=' . $tags[$i] . '" rel="tag">' . $tags[$i] . '</a>';
    }

    $pageName = $RawImageName . '.php';
    $fh = fopen($pageName, "w");
    $html = '<!DOCTYPE html>' .
        '<html lang="en">' .
        '<head>' .
        '<meta charset="UTF-8">' .
        '<meta http-equiv="X-UA-Compatible" content="IE=edge">' .
        '<meta name="viewport" content="width=device-width, initial-scale=1.0">' .
        '<meta name="keywords" content="' . $keywordsLine . '">' .
        '<meta name="description" content="' . $description . '">' .
        '<meta itemprop="name" content="' . $title . '">' .
        '<meta itemprop="description" content="' . $description . '">' .
        '<meta itemprop="image" content="https://aiwallpaper.online/jpeg/' . $oriURL . '">' .
        '<meta property="og:title" content="' . $title . '">' .
        '<meta property="og:url" content="https://aiwallpaper.online/image/' . $RawImageName . '">' .
        '<meta property="og:description" content="' . $description . '">' .
        '<meta property="og:image" content="https://aiwallpaper.online/jpeg/' . $oriURL . '" />' .
        '<meta property="og:image:secure_url" content="https://aiwallpaper.online/jpeg/' . $oriURL . '" />' .
        '<meta property="og:image:type" content="image/jpeg" />' .
        '<meta property="og:image:alt" content="' . $title . '" /><?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'h_links.html'); ?>" .
        '<link rel="canonical" href="https://aiwallpaper.online/image/' . $RawImageName . '" />' .
        '<title>' . $title . '</title>' .
        '</head>' .
        '<body>' .
        '<div class="ai-container">' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'header.html'); ?>" .
        '<main class="ai-main" id="main-content">' .
        '<div class="heading">' .
        '<h1>' . $title . '</h1>' .
        '</div>' .
        '<section class="preview-image-box" itemprop="primaryImageOfPage" itemscope="" itemtype="http://schema.org/ImageObject">' .
        '<div class="pib-inside">' .
        '<div class="pib-left">' .
        '<meta itemprop="representativeOfPage" content="true">' .
        '<meta itemprop="isFamilyFriendly" content="true">' .
        '<figure class="img-box">' .
        '<img itemprop="contentUrl" src="/webp/' . $RawImageName . '.webp" alt="' . $title . '">' .
        '<br>' .
        '<figcaption>' . $title . '</figcaption>' .
        '</figure>' .
        '<div class="tag-list">' .
        $li_html .
        '</div>' .
        '<meta itemprop="keywords" content="' . $keywordsLine . '">' .
        '<meta itemprop="description" content="' . $description . '">' .
        '<link itemprop="thumbnail" href="https://aiwallpaper.online/jpeg/' . $oriURL . '">' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>" .
        '</div>' .
        '<div class="pib-right">' .
        '<div class="img-btns">' .
        '<div class="more-info">' .
        '<span>' .
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' .
        '<path fill="currentColor" d="M4.5,5 C3.67157288,5 3,5.67157288 3,6.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L19.5,19 C20.3284271,19 21,18.3284271 21,17.5 L21,9.5 C21,8.67157288 20.3284271,8 19.5,8 L14,8 C12.8954305,8 12,7.1045695 12,6 C12,5.44771525 11.5522847,5 11,5 L4.5,5 Z M4.5,4 L11,4 C12.1045695,4 13,4.8954305 13,6 C13,6.55228475 13.4477153,7 14,7 L19.5,7 C20.8807119,7 22,8.11928813 22,9.5 L22,17.5 C22,18.8807119 20.8807119,20 19.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,6.5 C2,5.11928813 3.11928813,4 4.5,4 Z"></path>' .
        '</svg> File Size : ' . $image_file_size_in_mb . '</span>' .
        '<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' .
        '<path fill="currentColor" d="M8.29289322,15 L3.5,15 C3.22385763,15 3,14.7761424 3,14.5 C3,14.2238576 3.22385763,14 3.5,14 L9.5,14 C9.77614237,14 10,14.2238576 10,14.5 L10,20.5 C10,20.7761424 9.77614237,21 9.5,21 C9.22385763,21 9,20.7761424 9,20.5 L9,15.7071068 L3.85355339,20.8535534 C3.65829124,21.0488155 3.34170876,21.0488155 3.14644661,20.8535534 C2.95118446,20.6582912 2.95118446,20.3417088 3.14644661,20.1464466 L8.29289322,15 Z M15.7071068,9 L20.5,9 C20.7761424,9 21,9.22385763 21,9.5 C21,9.77614237 20.7761424,10 20.5,10 L14.5,10 C14.2238576,10 14,9.77614237 14,9.5 L14,3.5 C14,3.22385763 14.2238576,3 14.5,3 C14.7761424,3 15,3.22385763 15,3.5 L15,8.29289322 L20.1464466,3.14644661 C20.3417088,2.95118446 20.6582912,2.95118446 20.8535534,3.14644661 C21.0488155,3.34170876 21.0488155,3.65829124 20.8535534,3.85355339 L15.7071068,9 Z"></path>' .
        '</svg> Size : ' . $wid . '×' . $hei . '</span>' .
        '</div>' .
        '<a href="/jpeg/' . $oriURL . '" download="aiwallpaper_online-' . $title . '">Download</a>' .
        '<strong>Share on :</strong>' .
        '<a title="Share on Twitter" href="https://twitter.com/share?url=https://aiwallpaper.online/image/' . $RawImageName . '"><i class="icon-size icon-settings twitter"></i></a>' .
        '<a title="Share on Whatsapp" href="https://api.whatsapp.com/send?text=https://aiwallpaper.online/image/' . $RawImageName . '"><i class="icon-size icon-settings whatsapp"></i></a>' .
        '<a title="Share on Facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://aiwallpaper.online/image/' . $RawImageName . '"><i class="icon-size icon-settings facebook"></i></a>' .
        '</div>' .
        '</div>' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'hori-ads.html'); ?>" .
        '</div>' .
        '</div>' .
        '</section>' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>" .
        '<section class="ai-image-gallery">' .
        '<?php $_wallpaper = "' . $_wallpaper . '";  include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'relative.php'); ?>" .
        '</section>' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'wide-ads.html'); ?>" .
        '</main>' .
        '<?php include($' . '_SERVER' . "['DOCUMENT_ROOT'] . '/component/' . 'footer.html'); ?>" .
        '</body>' .
        '</html>';

    fwrite($fh, $html);
    fclose($fh);
    $msg = rename('../red_zone/' . $pageName, '../../image/' . $pageName);
    if ($msg) {
        return true;
    } else {
        return false;
    }
}

// this is a message sender that will send return message in json format
function msgSender($MSG, $FLAG)
{
    $msgArr = array(
        "msg" => $MSG,
        "flag" => $FLAG
    );
    if ($FLAG == 's') {
        echo json_encode($msgArr);
        exit;
    } else if ($FLAG == 'w') {
        echo json_encode($msgArr);
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars(($data));
    return $data;
}
?>