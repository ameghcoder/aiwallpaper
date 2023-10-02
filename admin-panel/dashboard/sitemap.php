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
    <title>Sitemap >> Wallpaper Access</title>
    <style>
        .btn{
            margin: 10px;
            padding: 5px 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="th-left">Admin Panel <Strong>About</Strong></div>
           <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_top_header.html') ?>
        </header>
        <div class="container-inside">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_left_header.html'); ?>
            <main class="main-content">
                <h2 style="padding-left:5px;border-left:5px solid black;font-size:19px;margin:0px 0px 10px 0px;">Update Recent Section</h2>
                <button type="button" class="btn update-recent-section-code-d">update Recent Section</button>
                <h2 style="padding-left:5px;border-left:5px solid black;font-size:19px;margin:0px 0px 10px 0px;">Update Sitemap</h2>
                <button type="button" class="btn update-sitemap-code">Image Sitemap Update</button>
            </main>
        </div>
    </div>
<div class="message-printer-box">
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.js" integrity="sha512-nO7wgHUoWPYGCNriyGzcFwPSF+bPDOR+NvtOYy2wMcWkrnCNPKBcFEkU80XIN14UVja0Gdnff9EmydyLlOL7mQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/admin-panel/script/sitemap_v01.js"></script>
</body>
</html>