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
    <title>About >> Wallpaper Access</title>
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
                <section class="content" style="height : 100%;">
                    <div class="about-card">
                        <div class="card">
                            <div class="card-inside">
                                <img src="../assets/user.jpg" alt="user profile image">
                                <h1>Isha</h1>
                                <p class="about-user">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero, veniam architecto. Nulla perferendis ea ducimus rem. Nemo unde, eum ipsum odio ex quia facere totam facilis dignissimos voluptatibus mollitia. Repudiandae.</p>
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