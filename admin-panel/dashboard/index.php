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
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <header class="top-header">
            <div class="th-left">Admin Panel <Strong>Home</Strong></div>
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_top_header.html') ?>
        </header>
        <div class="container-inside">
            <?php include($_SERVER['DOCUMENT_ROOT'] . '/admin-panel/component/' . 'in_left_header.html'); ?>
            <main class="main-content">
                <section class="content">
                    <div class="user-details">
                        <div class="ud-inside">
                            <div class="ud-top">
                            </div>
                            <div class="ud-btm">
                                <div class="ud-btm-user-image">
                                    <img src="../assets/channel.png" alt="ocean of code logo">
                                </div>
                                <div class="ud-btm-user-name">Ankit</div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include($_SERVER['DOCUMENT_ROOT'].'/admin-panel/component/'.'footer.html') ?>
            </main>
        </div>
    </div>
</body>
</html>