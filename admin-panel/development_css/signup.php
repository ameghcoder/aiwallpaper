<?php

// This script will handle login
session_start();

// Check if the user is already logged in

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/admin-panel/component/' . 'no_robots.html') ?>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/admin-panel/component/' . 'out_head_file.html') ?>
    <title>Singup || Admin Panel >> Wallpaper Access</title>
</head>
<body>
    <h1 class="out-h1">Admin Panel</h1>
    <div class="out-container">
        <div class="out-container-left">
            <div class="blurry-effect"></div>
        </div>
        <div class="out-container-right">
            <form action="" method="POST" enctype="multipart/form-data">
                <h2>
                    <?php
                        if(!empty($username_err)){
                            echo $username_err;
                        } else if(!empty($password_err)){
                            echo $password_err;
                        } else{
                            echo "For Only Members";
                        }
                    ?>
                </h2>
                <hr>
                <div class="input-groups">
                    <input type="text" name="name" placeholder="Enter your name">
                    <input type="email" name="useremail" placeholder="Enter your email">
                    <input type="text" class="otp-code" placeholder="Enter your OTP">
                    <input type="text" name="username" placeholder="Enter your username">
                    <input type="password" name="password" placeholder="Enter new password">
                    <button type="submit">Create account</button>
                </div>
                <hr>
                <div class="flex space-between">
                    <span>You have an account.<a style="color : lime" href="./"> Login</span>
                </div>
            </form>
        </div>
    </div>
</body>
</html>