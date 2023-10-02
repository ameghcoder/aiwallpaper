<?php

// This script will handle login
session_start();

// Check if the user is already logged in
if(isset($_SESSION['username'])){
    header('location: /admin-panel/dashboard/');
    exit;
}else{
    require_once "SDC.php";
 
    $username = $password = "";
    $username_err = $password_err = "";

    // if request method is post
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(empty(trim($_POST['username'])) || empty(trim($_POST['password']))){
            $err = "Please enter a username or password";
        } else{
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
        }
        if(empty($err)){
             $sql = "SELECT id, username, password FROM wa_users WHERE username = ?";
             $stmt = mysqli_prepare($connection, $sql);
             mysqli_stmt_bind_param($stmt, "s", $param_username);
             // Set the value of param username
             $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // This means the password is correct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            // Redirect User to welcome page
                            header('location: /admin-panel/dashboard/');
                        }else{
                            $password_err = "Please enter right password";
                        }
                    }
                } else{
                    $username_err = "This username is not exits.";
                }
            } else{
                echo "Something went wrong.";
            }
            mysqli_stmt_close($stmt);
             
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/admin-panel/component/' . 'no_robots.html') ?>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/admin-panel/component/' . 'out_head_file.html') ?>
    <title>Login || Admin Panel >> Wallpaper Access</title>
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

                    <input type="text" name="username" placeholder="Enter your username">
                    <input type="password" name="password" placeholder="Enter your Password">
                    <button type="submit">Log in</button>
                </div>
                <hr>
            </form>
        </div>
    </div>
</body>
</html>