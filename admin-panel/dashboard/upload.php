
<?php
// Start the session
session_start();
if(isset($_SESSION['username'])){
    $usernameTeam = $_SESSION['username'];
} else{
    header('location: /admin-panel/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_head_file.html') ?>
    <title>Upload >> Wallpaper Access</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="th-left">Admin Panel <Strong>Upload</Strong></div>
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_top_header.html') ?>
        </header>
        <div class="container-inside">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_left_header.html'); ?>
            <main class="main-content">
                <section class="content">
                    <div class="upload-image-section">
                        <div class="uis-top">
                            <div class="click-here">
                                <label for="wallpaper">
                                    Click Here to Upload
                                </label>
                                <input type="file" name="wallpaper" id="wallpaper" accept="image/*" hidden>
                                <strong id="username" hidden>
                                    <?php
                                        session_start();
                                        if(isset($_SESSION['username'])){
                                            echo $_SESSION['username'];
                                        } else{
                                            echo "Akki6377";
                                        }
                                    ?>
                                </strong>
                            </div>
                            <div class="preview-image">
                                <img class="preview" src="">
                            </div>
                        </div>
                        <div class="uis-mid">
                            <input type="text" name="wallpaper-name" id="wallpaper-name" placeholder="Enter Wallpaper Name">
                        </div>
                        <div class="uis-btm">
                            <strong>Keywords Length : <em class="_keyword_length"></em>, Not more than 250 characters</strong>
                            <textarea name="tags" id="tags" cols="30" rows="10" placeholder="Enter Wallpaper Tags"></textarea>
                            <strong>Description Length : <em class="_description_length"></em>, Not more than 160 characters or Less than 100 characters</strong>
                            <textarea name="description" id="description" cols="30" rows="10" placeholder="Write something about wallpaper"></textarea>
                            <button type="button" class="uploadBtn">Upload</button>
                        </div>
                    </div>
                </section>
                <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'footer.html') ?>
            </main>
        </div>
    </div>
</body>
</html>