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
    <title>Message >> Wallpaper Access</title>
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
                
            </main>
        </div>
    </div>
</body>
</html>